<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Services\WhatsAppService;
use App\Services\ZoomService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Throwable;

class AppointmentController extends Controller
{
    public function __construct(
        private ZoomService $zoomService,
        private WhatsAppService $whatsAppService,
    ) {
    }

    public function index(Request $request)
    {
        $query = Appointment::with(['doctor', 'schedule', 'prescription'])
            ->where(function ($query) {
                $query->whereNull('appointment_type')
                    ->orWhere('appointment_type', '!=', 'prescription');
            });

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $appointments = $query->latest()->paginate(15)->withQueryString();

        return view('admin.appointments.index', compact('appointments'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,accepted,rejected,completed'],
        ]);

        if ($validated['status'] === 'accepted') {
            return $this->accept($request, $appointment);
        }

        if ($validated['status'] === 'rejected') {
            return $this->reject($appointment);
        }

        $appointment->update($validated);

        return back()->with('success', 'Appointment status updated.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return back()->with('success', 'Appointment removed.');
    }

    public function accept(Request $request, Appointment $appointment)
    {
        if ($appointment->status === 'accepted') {
            return back()->with('success', 'Appointment is already accepted.');
        }

        $request->validate([
            'duration' => ['nullable', 'integer', 'min:15', 'max:180'],
        ]);

        try {
            if ($this->isTelemedicine($appointment) && ! $this->zoomCredentialsConfigured()) {
                $appointment->update([
                    'status' => 'accepted',
                    'zoom_join_url' => null,
                    'zoom_start_url' => null,
                    'zoom_meeting_id' => null,
                ]);

                $message = 'Appointment accepted without Zoom link because Zoom credentials are not configured. Add ZOOM_ACCOUNT_ID, ZOOM_CLIENT_ID, and ZOOM_CLIENT_SECRET in .env to generate links.';

                $message .= $this->buildWhatsAppStatusMessage($appointment->fresh(['doctor', 'schedule']));

                return back()->with('success', $message);
            }

            $meeting = [
                'join_url' => null,
                'start_url' => null,
                'meeting_id' => null,
            ];

            if ($this->isTelemedicine($appointment)) {
                $meeting = $this->zoomService->createMeeting([
                    'topic' => 'Telemedicine Appointment - ' . ($appointment->name ?: 'Patient'),
                    'agenda' => 'HospiBridge telemedicine session',
                    'start_time' => $this->buildMeetingStartTime($appointment),
                    'duration' => (int) $request->input('duration', 30),
                ]);
            }

            $appointment->update([
                'status' => 'accepted',
                'zoom_join_url' => $meeting['join_url'],
                'zoom_start_url' => $meeting['start_url'],
                'zoom_meeting_id' => $meeting['meeting_id'],
                // Keep compatibility with older views that still use this field.
                'zoom_meeting_link' => $meeting['join_url'] ?: $appointment->zoom_meeting_link,
            ]);

            return back()->with('success', 'Appointment accepted.' . $this->buildWhatsAppStatusMessage($appointment->fresh(['doctor', 'schedule'])));
        } catch (Throwable $e) {
            return back()->with('error', 'Failed to accept appointment: ' . $e->getMessage());
        }
    }

    public function reject(Appointment $appointment)
    {
        $appointment->update([
            'status' => 'rejected',
            'zoom_join_url' => null,
            'zoom_start_url' => null,
            'zoom_meeting_id' => null,
            'zoom_meeting_link' => null,
        ]);

        return back()->with('success', 'Appointment rejected.');
    }

    public function acceptAndNotify(Request $request, Appointment $appointment)
    {
        return $this->accept($request, $appointment);
    }

    public function whatsappLink(Appointment $appointment)
    {
        $link = $this->whatsAppService->buildWaMeLink($appointment->loadMissing(['doctor', 'schedule']));

        if ($link === null) {
            return back()->with('error', 'Cannot build a WhatsApp link because the patient phone number is missing.');
        }

        return redirect()->away($link);
    }

    private function isTelemedicine(Appointment $appointment): bool
    {
        return strtolower((string) $appointment->appointment_type) === 'telemedicine';
    }

    private function buildMeetingStartTime(Appointment $appointment): string
    {
        $date = (string) ($appointment->schedule->date ?? '');
        $time = (string) ($appointment->schedule->start_time ?? '');

        if ($date !== '' && $time !== '') {
            return Carbon::parse($date . ' ' . $time, config('app.timezone'))->toIso8601String();
        }

        return now()->addHour()->toIso8601String();
    }

    private function zoomCredentialsConfigured(): bool
    {
        return (string) config('services.zoom.account_id') !== ''
            && (string) config('services.zoom.client_id') !== ''
            && (string) config('services.zoom.client_secret') !== '';
    }

    private function whatsAppCredentialsConfigured(): bool
    {
        return (string) config('services.whatsapp.token') !== ''
            && (string) config('services.whatsapp.phone_number_id') !== '';
    }

    private function buildWhatsAppStatusMessage(Appointment $appointment): string
    {
        if (! $this->whatsAppCredentialsConfigured()) {
            return ' Automatic WhatsApp send is not configured. Use the Send WhatsApp button to notify the patient manually.';
        }

        try {
            $sent = $this->whatsAppService->sendAppointmentLink($appointment);

            if (! $sent) {
                return ' WhatsApp notification was skipped because patient phone is missing.';
            }

            return ' WhatsApp notification sent successfully.';
        } catch (Throwable $e) {
            return ' WhatsApp notification could not be sent at this time.';
        }
    }
}
