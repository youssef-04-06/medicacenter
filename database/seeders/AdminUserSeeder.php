<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Change this password after your first login!
        User::updateOrCreate(
            ['email' => 'admin@medicacenter.test'],
            [
                'name' => 'HospiBridge Admin',
                'password' => Hash::make('AdminPass123!'),
                'role' => 'admin',
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
