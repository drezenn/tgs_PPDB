<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Akun sampel Admin
        User::updateOrCreate(
            ['email' => 'admin@sekolah.sch.id'],
            [
                'name' => 'Admin PPDB',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Akun sampel Panitia
        User::updateOrCreate(
            ['email' => 'panitia@sekolah.sch.id'],
            [
                'name' => 'Panitia PPDB',
                'password' => Hash::make('panitia123'),
                'role' => 'panitia',
                'email_verified_at' => now(),
            ]
        );

        // Akun sampel Panitia tambahan
        User::updateOrCreate(
            ['email' => 'panitia1@sekolah.sch.id'],
            [
                'name' => 'Panitia 1',
                'password' => Hash::make('panitia123'),
                'role' => 'panitia',
                'email_verified_at' => now(),
            ]
        );
    }
}
