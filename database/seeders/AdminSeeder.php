<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@dormitory.com',
            'password' => Hash::make('password123'),
            'role' => 'admin', 
        ]);

         User::create([
            'name' => 'John Doe',
            'email' => 'j@test.com',
            'password' => Hash::make('password123'),
            'role' => 'student', 
        ]);
    }
}
