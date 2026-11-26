<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function request(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        Appointment::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'email' => $user->email,
            'phone' => $validated['phone'] ?? null,
            'doctor_id' => $validated['doctor_id'],
            'appointment_type' => 'prescription',
            'message' => $validated['message'],
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Prescription request submitted. The care team will add it to your account after review.');
    }

    public function store(Request $request, Appointment $appointment)
    {
        $user = $request->user();
        $isDoctorLike = $user->is_admin || in_array(strtolower((string) $user->role), ['doctor', 'admin'], true);

        abort_unless($isDoctorLike, 403, 'Only doctors or admins can issue prescriptions.');

        $isPrescriptionRequest = strtolower((string) $appointment->appointment_type) === 'prescription';

        if (! $user->is_admin && strtolower((string) $user->role) === 'doctor') {
            abort_unless($user->doctor && (int) $appointment->doctor_id === (int) $user->doctor->id, 403, 'You can only issue prescriptions for your own patients.');
        }

        $validated = $request->validate([
            'medication' => ['required', 'string', 'max:255'],
            'dosage' => ['required', 'string', 'max:255'],
            'instructions' => ['required', 'string'],
        ]);

        if (! $appointment->doctor_id && ! $isPrescriptionRequest) {
            return back()->with('error', 'Appointment must be assigned to a doctor before creating a prescription.');
        }

        if (! $appointment->user_id) {
            $patient = User::where('email', $appointment->email)->first();
            if ($patient) {
                $appointment->update(['user_id' => $patient->id]);
                $appointment->refresh();
            }
        }

        if (! $appointment->user_id) {
            return back()->with('error', 'Appointment must be assigned to a doctor and patient before creating a prescription.');
        }

        $content = "Medication: {$validated['medication']}\n" .
            "Dosage: {$validated['dosage']}\n" .
            "Instructions: {$validated['instructions']}";

        Prescription::updateOrCreate(
            ['appointment_id' => $appointment->id],
            [
                'doctor_id' => $appointment->doctor_id ?: $user->doctor?->id,
                'patient_id' => $appointment->user_id,
                'content' => $content,
            ]
        );

        return back()->with('success', 'Prescription saved successfully.');
    }

    public function download(Request $request, Appointment $appointment)
    {
        $user = $request->user();
        $isAdmin = $user && ($user->is_admin || strtolower((string) $user->role) === 'admin');
        $canDownload = $user
            && ($isAdmin
            || (int) $appointment->user_id === (int) $user->id
            || ($appointment->user_id === null && strcasecmp((string) $appointment->email, (string) $user->email) === 0));

        abort_unless($canDownload, 403);

        $prescription = Prescription::with(['doctor', 'patient'])
            ->where('appointment_id', $appointment->id)
            ->firstOrFail();

        $patient = $appointment->user ?: User::where('email', $appointment->email)->firstOrFail();

        $pdf = Pdf::loadView('prescriptions.pdf', [
            'appointment' => $appointment->loadMissing(['doctor', 'schedule']),
            'prescription' => $prescription,
            'patient' => $patient,
        ]);

        return $pdf->download('prescription-appointment-' . $appointment->id . '.pdf');
    }
}
