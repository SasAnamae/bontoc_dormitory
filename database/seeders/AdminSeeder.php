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
            'name' => 'Cashier',
            'email' => 'cashier@dormitory.com',
            'password' => Hash::make('password123'),
            'role' => 'cashier', 
        ]);
    }
}
