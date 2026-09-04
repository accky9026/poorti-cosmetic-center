<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@poorti.com'],
            [
                'name' => 'Poorti Admin',
                'phone' => '9999999999',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );
    }
}
