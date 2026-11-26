<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\User;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            ['name' => 'Dr. John', 'email' => 'john@example.com', 'password' => 'DoctorJohn123!', 'phone' => '123456', 'specialty' => 'Cardiology', 'address' => 'Clinic 1'],
            ['name' => 'Dr. Smith', 'email' => 'smith@example.com', 'password' => 'DoctorSmith123!', 'phone' => '789012', 'specialty' => 'Dermatology', 'address' => 'Clinic 2'],
            ['name' => 'Dr. Lee', 'email' => 'lee@example.com', 'password' => 'DoctorLee123!', 'phone' => '345678', 'specialty' => 'Neurology', 'address' => 'Clinic 3'],
        ];

        foreach ($doctors as $d) {
            $user = User::updateOrCreate(
                ['email' => $d['email']],
                ['name' => $d['name'], 'password' => $d['password'], 'role' => 'doctor']
            );

            $doctor = Doctor::updateOrCreate(
                ['email' => $d['email']],
                [
                    'name' => $d['name'],
                    'phone' => $d['phone'],
                    'specialty' => $d['specialty'],
                    'address' => $d['address'],
                    'user_id' => $user->id,
                ]
            );

            // Add a schedule for each doctor
            DoctorSchedule::create([
                'doctor_id' => $doctor->id,
                'date' => now()->addDays($doctor->id), // example dates
                'start_time' => '09:00:00',
                'end_time' => '09:30:00',
            ]);
        }
    }
}