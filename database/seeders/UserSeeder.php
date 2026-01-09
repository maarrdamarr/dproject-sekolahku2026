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
        $this->seedUser('Admin Sekolah', 'admin@sekolah.test', 'admin');
        $this->seedUser('Guru Demo', 'guru@sekolah.test', 'guru');
        $this->seedUser('Siswa Demo', 'siswa@sekolah.test', 'siswa');
    }

    private function seedUser(string $name, string $email, string $role): void
    {
        $user = User::firstOrNew(['email' => $email]);
        $user->name = $name;
        $user->role = $role;

        if (!$user->exists || !$user->password) {
            $user->password = Hash::make('password');
        }

        $user->save();
    }
}
