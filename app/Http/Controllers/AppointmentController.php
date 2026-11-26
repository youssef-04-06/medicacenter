<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Payment;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => "required",
            "email" => "required|email",
            "phone" => "nullable",
            "doctor_id" => "nullable|exists:doctors,id",
            "schedule_id" => "nullable|exists:doctor_schedules,id",
            "doctor_name" => "nullable|string",
            "slot" => "nullable|string",
            "appointment_type" => "nullable|in:normal,telemedicine,vaccination",
            "location" => "nullable|string",
            "urgency" => "nullable|string",
            "symptoms" => "nullable|string",
            "vaccine_name" => "nullable|string",
            "dose_number" => "nullable|string",
            "vaccine_date" => "nullable|date",
            "allergies" => "nullable|string",
            "whish_number" => "nullable|string",
            "whish_reference" => "nullable|string",
            "message" => "nullable"
        ]);

        $doctor = $this->resolveDoctor($validated);
        $schedule = $this->resolveSchedule($doctor, $validated);

        if (! $doctor || ! $schedule) {
            return response()->json([
                'success' => false,
                'message' => 'No available doctor schedule could be matched for this booking.'
            ], 422);
        }

        $scheduleDateTime = \Illuminate\Support\Carbon::parse($schedule->date . ' ' . $schedule->start_time);
        if ($scheduleDateTime->isPast()) {
            return response()->json([
                'success' => false,
                'message' => 'This time slot is no longer available.'
            ], 422);
        }

        $alreadyBooked = Appointment::query()
            ->where('schedule_id', $schedule->id)
            ->exists();

        if ($alreadyBooked) {
            return response()->json([
                'success' => false,
                'message' => 'This time slot has already been booked.'
            ], 422);
        }

        try {
            $appointment = Appointment::create([
                'user_id' => $request->user()?->id,
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'doctor_id' => $doctor->id,
                'schedule_id' => $schedule->id,
                'appointment_type' => $validated['appointment_type'] ?? 'normal',
                'appointment_details' => $this->buildAppointmentDetails($validated),
                'message' => $validated['message'] ?? null,
                'status' => 'pending',
            ]);

            if (($validated['appointment_type'] ?? 'normal') === 'telemedicine' && ! empty($validated['whish_reference'])) {
                Payment::updateOrCreate(
                    ['appointment_id' => $appointment->id],
                    [
                        'user_id' => $appointment->user_id,
                        'doctor_id' => $appointment->doctor_id,
                        'amount' => 20,
                        'payment_method' => 'whish',
                        'status' => 'pending',
                        'sender_number' => $validated['whish_number'] ?? null,
                        'reference' => $validated['whish_reference'],
                    ]
                );
            }

            return response()->json(['success' => true]);
        } catch (QueryException $e) {
            return response()->json([
                'success' => false,
                'message' => 'This time slot has already been booked.'
            ], 409);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not save appointment. Please try again.'
            ], 500);
        }
    }

    protected function resolveDoctor(array $validated): ?Doctor
    {
        if (! empty($validated['doctor_id'])) {
            return Doctor::find($validated['doctor_id']);
        }

        $doctorName = trim((string) ($validated['doctor_name'] ?? ''));
        if ($doctorName === '') {
            return null;
        }

        return Doctor::where('name', $doctorName)
            ->orWhere('name', 'like', '%' . $doctorName . '%')
            ->first();
    }

    protected function resolveSchedule(?Doctor $doctor, array $validated): ?DoctorSchedule
    {
        if (! $doctor) {
            return null;
        }

        if (! empty($validated['schedule_id'])) {
            return $doctor->schedules()->whereKey($validated['schedule_id'])->first();
        }

        $schedules = $doctor->schedules()->orderBy('date')->orderBy('start_time')->get();
        if ($schedules->isEmpty()) {
            return null;
        }

        $slot = trim((string) ($validated['slot'] ?? ''));
        if ($slot === '') {
            return $schedules->first();
        }

        $slotDigits = preg_replace('/[^0-9]/', '', $slot);
        foreach ($schedules as $schedule) {
            $startTime = (string) $schedule->start_time;
            $startDigits = preg_replace('/[^0-9]/', '', $startTime);

            if (str_contains(strtolower($slot), strtolower($startTime))
                || str_contains(strtolower($startTime), strtolower($slot))
                || str_contains($slotDigits, $startDigits)
                || str_contains($startDigits, $slotDigits)) {
                return $schedule;
            }
        }

        return $schedules->first();
    }

    protected function buildAppointmentDetails(array $validated): ?array
    {
        $details = [
            'location' => $validated['location'] ?? null,
            'urgency' => $validated['urgency'] ?? null,
            'symptoms' => $validated['symptoms'] ?? null,
            'vaccine_name' => $validated['vaccine_name'] ?? null,
            'dose_number' => $validated['dose_number'] ?? null,
            'vaccine_date' => $validated['vaccine_date'] ?? null,
            'allergies' => $validated['allergies'] ?? null,
            'whish_number' => $validated['whish_number'] ?? null,
            'whish_reference' => $validated['whish_reference'] ?? null,
            'message' => $validated['message'] ?? null,
        ];

        $filtered = array_filter($details, static fn ($value) => $value !== null && $value !== '');

        return $filtered === [] ? null : $filtered;
    }
}