<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{
    public function index(Doctor $doctor)
    {
        $schedules = $doctor->schedules()->orderBy('date')->orderBy('start_time')->get();

        return view('admin.schedules.index', compact('doctor', 'schedules'));
    }

    public function create(Doctor $doctor)
    {
        return view('admin.schedules.create', compact('doctor'));
    }

    public function store(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ]);

        $doctor->schedules()->create($validated);

        return redirect()->route('admin.doctors.schedules.index', $doctor)
            ->with('success', 'Time slot added successfully.');
    }

    public function destroy(Doctor $doctor, DoctorSchedule $schedule)
    {
        $schedule->delete();

        return back()->with('success', 'Time slot removed successfully.');
    }
}
