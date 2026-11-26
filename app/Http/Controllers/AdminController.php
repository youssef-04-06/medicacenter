<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // 🏠 Dashboard method
    public function dashboard()
{
    // 🔢 Counts for dashboard cards
    $usersCount = User::count();
    $doctorsCount = 5;
    $appointmentsCount = Appointment::count();
    $pendingCount = Appointment::where('status', 'pending')->count();

    $appointments = Appointment::latest()->take(5)->get();
    $contacts = Contact::latest()->take(10)->get();

    $chartData = Appointment::selectRaw('DATE(created_at) as date, COUNT(*) as count')
        ->groupByRaw('DATE(created_at)')
        ->orderBy('date', 'asc')
        ->pluck('count', 'date');

    return view('admin', [
        'usersCount' => $usersCount,
        'doctorsCount' => $doctorsCount,
        'appointmentsCount' => $appointmentsCount,
        'pendingCount' => $pendingCount,
        'appointments' => $appointments,
        'contacts' => $contacts,
        'chartLabels' => $chartData->keys(),
        'chartValues' => $chartData->values(),
    ]);
}
public function deleteMessage($id)
{
    Contact::findOrFail($id)->delete();
    return back()->with('success', 'Message deleted successfully.');
}}