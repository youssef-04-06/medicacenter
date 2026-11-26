<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function index()
    {
        $requests = Appointment::with(['user', 'doctor', 'prescription'])
            ->where('appointment_type', 'prescription')
            ->latest()
            ->paginate(15);

        return view('admin.prescriptions.index', compact('requests'));
    }

    public function store(Request $request, Appointment $appointment)
    {
        abort_unless($appointment->appointment_type === 'prescription', 404);

        $validated = $request->validate([
            'medication' => ['required', 'string', 'max:255'],
            'dosage' => ['required', 'string', 'max:255'],
            'instructions' => ['required', 'string'],
        ]);

        $content = "Medication: {$validated['medication']}\n"
            . "Dosage: {$validated['dosage']}\n"
            . "Instructions: {$validated['instructions']}";

        Prescription::updateOrCreate(
            ['appointment_id' => $appointment->id],
            [
                'doctor_id' => $appointment->doctor_id,
                'patient_id' => $appointment->user_id,
                'content' => $content,
            ]
        );

        $appointment->update(['status' => 'completed']);

        return back()->with('success', 'Prescription saved and made available to the patient.');
    }

    public function destroy(Appointment $appointment)
    {
        abort_unless($appointment->appointment_type === 'prescription', 404);

        $appointment->delete();

        return back()->with('success', 'Prescription request removed.');
    }
}