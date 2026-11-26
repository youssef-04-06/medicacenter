<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Call doctors, schedules, and admin-account seeders
        $this->call([
            DoctorSeeder::class,
            DoctorScheduleSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}