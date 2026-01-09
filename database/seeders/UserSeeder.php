<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Sekolah',
            'email' => 'admin@sekolah.test',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Guru Demo',
            'email' => 'guru@sekolah.test',
            'password' => Hash::make('password'),
            'role' => 'guru'
        ]);

        User::create([
            'name' => 'Siswa Demo',
            'email' => 'siswa@sekolah.test',
            'password' => Hash::make('password'),
            'role' => 'siswa'
        ]);
    }
}

