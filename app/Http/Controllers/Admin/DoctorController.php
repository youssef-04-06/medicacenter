<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::withCount(['schedules', 'appointments'])->latest()->get();

        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:doctors,email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'specialty' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'login_password' => ['nullable', 'string', 'min:6'],
        ]);

        $loginPassword = $validated['login_password'] ?? null;
        unset($validated['login_password']);

        $doctor = Doctor::create($validated);

        if ($loginPassword) {
            $this->syncDoctorLogin($doctor, $loginPassword);
        }

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor added successfully.');
    }

    public function edit(Doctor $doctor)
    {
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:doctors,email,' . $doctor->id],
            'phone' => ['nullable', 'string', 'max:50'],
            'specialty' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'login_password' => ['nullable', 'string', 'min:6'],
        ]);

        $loginPassword = $validated['login_password'] ?? null;
        unset($validated['login_password']);

        $doctor->update($validated);

        if ($loginPassword) {
            $this->syncDoctorLogin($doctor, $loginPassword);
        }

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor updated successfully.');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();

        return back()->with('success', 'Doctor removed successfully.');
    }

    private function syncDoctorLogin(Doctor $doctor, string $password): void
    {
        abort_if(! $doctor->email, 422, 'Doctor must have an email to create login credentials.');

        $user = $doctor->user ?: User::where('email', $doctor->email)->first();

        if ($user) {
            $user->update([
                'name' => $doctor->name,
                'password' => Hash::make($password),
                'role' => 'doctor',
            ]);
        } else {
            $user = User::create([
                'name' => $doctor->name,
                'email' => $doctor->email,
                'password' => Hash::make($password),
                'role' => 'doctor',
            ]);
        }

        $doctor->update(['user_id' => $user->id]);
    }
}
