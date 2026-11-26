<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Invalid email or password.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // Attach any bookings created before auth (same email) to this account.
        Appointment::whereNull('user_id')
            ->where('email', $user->email)
            ->update(['user_id' => $user->id]);

        if ($user->is_admin) {
            return redirect()->route('admin.dashboard')->with('success', 'Welcome back, admin!');
        }

        if (strtolower((string) $user->role) === 'doctor' && $user->doctor) {
            return redirect()->route('doctor.dashboard')->with('success', 'Welcome back, Dr. ' . $user->name . '!');
        }

        return redirect()->route('dashboard')->with('success', 'Login successful!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
