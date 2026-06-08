<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat admin user
        User::updateOrCreate(
            ['email' => 'admin@stressanalyzer.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // $this->command->info('Admin user berhasil dibuat!');
        // $this->command->info('Email: admin@stressanalyzer.com');
        // $this->command->info('Password: admin123');
    }
}
