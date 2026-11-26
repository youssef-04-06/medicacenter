<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DoctorSchedule;
use App\Models\Doctor;

class DoctorScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = Doctor::all();

        foreach ($doctors as $doctor) {
            $baseDay = now()->startOfDay();

            DoctorSchedule::create([
                'doctor_id' => $doctor->id,
                'date' => $baseDay->copy()->addDays(1)->toDateString(),
                'start_time' => '09:00:00',
                'end_time' => '10:00:00'
            ]);
            DoctorSchedule::create([
                'doctor_id' => $doctor->id,
                'date' => $baseDay->copy()->addDays(2)->toDateString(),
                'start_time' => '10:00:00',
                'end_time' => '11:00:00'
            ]);
            DoctorSchedule::create([
                'doctor_id' => $doctor->id,
                'date' => $baseDay->copy()->addDays(4)->toDateString(),
                'start_time' => '14:00:00',
                'end_time' => '15:00:00'
            ]);
        }
    }
}