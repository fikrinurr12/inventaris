<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Muhammad Fikri Nursyahbani',
            'email' => 'fikri@gmail.com',
            'password' => Hash::make('fikri123')
        ]);

        $user->assignRole('superadmin');

        $user2 = User::create([
            'name' => 'Fasya Maulinada',
            'email' => 'fasya@gmail.com',
            'password' => Hash::make('fasya123')
        ]);

        $user2->assignRole('superadmin');
    }
}
