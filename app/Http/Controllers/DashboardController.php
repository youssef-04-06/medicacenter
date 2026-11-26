<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->buildAppointmentData($request);

        return view('portal.patient-dashboard', $data);
    }

    public function myAppointments(Request $request)
    {
        $data = $this->buildAppointmentData($request);

        return view('portal.my-appointments', $data);
    }

    public function prescriptions(Request $request)
    {
        $user = $request->user();

        $prescriptions = Appointment::with(['doctor', 'schedule', 'prescription'])
            ->where('user_id', $user->id)
            ->whereHas('prescription')
            ->latest()
            ->get();

        return view('portal.prescriptions', compact('prescriptions', 'user'));
    }

    private function buildAppointmentData(Request $request): array
    {
        $user = $request->user();

        Appointment::whereNull('user_id')
            ->where('email', $user->email)
            ->update(['user_id' => $user->id]);

        $appointments = Appointment::with(['doctor', 'schedule', 'prescription'])
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere(function ($subQuery) use ($user) {
                        $subQuery->whereNull('user_id')
                            ->where('email', $user->email);
                    });
            })
                    ->where(function ($query) {
                    $query->whereNull('appointment_type')
                        ->orWhere('appointment_type', '!=', 'prescription');
                    })
            ->latest()
            ->paginate(8);

        $appointmentSummary = [
            'total' => Appointment::where('user_id', $user->id)->where(function ($query) {
                $query->whereNull('appointment_type')->orWhere('appointment_type', '!=', 'prescription');
            })->count(),
            'pending' => Appointment::where('user_id', $user->id)->where('status', 'pending')->where(function ($query) {
                $query->whereNull('appointment_type')->orWhere('appointment_type', '!=', 'prescription');
            })->count(),
            'accepted' => Appointment::where('user_id', $user->id)->whereIn('status', ['accepted', 'confirmed'])->where(function ($query) {
                $query->whereNull('appointment_type')->orWhere('appointment_type', '!=', 'prescription');
            })->count(),
            'prescriptions' => Appointment::where('user_id', $user->id)->whereHas('prescription')->count(),
        ];

        return compact('appointments', 'appointmentSummary', 'user');
    }
}
