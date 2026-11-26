<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create and save the user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = 'patient';
        $user->hospital_id = $request->hospital_id ?? null;
        $user->is_admin = false;
        $user->save();

        // Auto-login after registration
        Auth::login($user);

        // Attach prior bookings made with the same email before account creation.
        Appointment::whereNull('user_id')
            ->where('email', $user->email)
            ->update(['user_id' => $user->id]);

        return redirect()->route('dashboard')->with('success', 'Registration successful!');
    }
}