<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Contact;
use App\Models\Doctor;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $usersCount = User::count();
        $doctorsCount = Doctor::count();
        $appointmentsCount = Appointment::count();
        $pendingCount = Appointment::where('status', 'pending')->count();

        $appointments = Appointment::with(['doctor', 'schedule'])->latest()->take(5)->get();
        $contacts = Contact::latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();

        $chartData = Appointment::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupByRaw('DATE(created_at)')
            ->orderBy('date', 'asc')
            ->take(14)
            ->pluck('count', 'date');

        return view('admin.dashboard', [
            'usersCount' => $usersCount,
            'doctorsCount' => $doctorsCount,
            'appointmentsCount' => $appointmentsCount,
            'pendingCount' => $pendingCount,
            'appointments' => $appointments,
            'contacts' => $contacts,
            'recentUsers' => $recentUsers,
            'chartLabels' => $chartData->keys(),
            'chartValues' => $chartData->values(),
        ]);
    }
}
