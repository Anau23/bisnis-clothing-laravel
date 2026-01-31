<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'email' => 'admin@dilisociety.test',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        User::create([
            'username' => 'cashier',
            'email' => 'cashier@dilisociety.test',
            'password' => Hash::make('cashier123'),
            'role' => 'cashier',
            'is_active' => true,
        ]);
    }
}
