<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'nip' => '1234567890',
            'password' => Hash::make('Admin123'),
            'role' => 'admin',
            'approved_by_admin' => 1,
            'email_verified_at' => now(),
        ]);
    }
}
