<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function appointments(Request $request)
    {
        $doctor = $request->user()->doctor;
        $appointments = $this->appointmentQuery($doctor)->latest()->paginate(15);

        return view('portal.doctor-appointments', compact('doctor', 'appointments'));
    }

    public function prescriptions(Request $request)
    {
        $doctor = $request->user()->doctor;
        $prescriptionRequests = \App\Models\Appointment::with(['user', 'prescription'])
            ->where('appointment_type', 'prescription')
            ->where('doctor_id', $doctor->id)
            ->latest()
            ->paginate(15);

        return view('portal.doctor-prescriptions', compact('doctor', 'prescriptionRequests'));
    }

    public function index(Request $request)
    {
        $doctor = $request->user()->doctor;

        $appointments = $doctor->appointments()
            ->with(['user', 'schedule', 'prescription'])
            ->where(function ($query) {
                $query->whereNull('appointment_type')
                    ->orWhere('appointment_type', '!=', 'prescription');
            })
            ->latest()
            ->paginate(10);

        $prescriptionRequests = \App\Models\Appointment::with(['user', 'prescription'])
            ->where('appointment_type', 'prescription')
            ->where('doctor_id', $doctor->id)
            ->latest()
            ->get();

        $appointmentSummary = [
            'total' => $doctor->appointments()->count(),
            'pending' => $doctor->appointments()->where('status', 'pending')->count(),
            'accepted' => $doctor->appointments()->whereIn('status', ['accepted', 'confirmed'])->count(),
            'completed' => $doctor->appointments()->where('status', 'completed')->count(),
        ];

        return view('portal.doctor-dashboard', compact('doctor', 'appointments', 'appointmentSummary', 'prescriptionRequests'));
    }

    private function appointmentQuery($doctor)
    {
        return $doctor->appointments()
            ->with(['user', 'schedule', 'prescription'])
            ->where(function ($query) {
                $query->whereNull('appointment_type')
                    ->orWhere('appointment_type', '!=', 'prescription');
            });
    }
}
