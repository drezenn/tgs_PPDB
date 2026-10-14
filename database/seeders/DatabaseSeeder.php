<?php

namespace Database\Seeders;

use App\Models\Major;
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

        // Data jurusan untuk form pendaftaran (Pilihan 1 & 2)
        $jurusan = [
            ['kode_jurusan' => 'RPL', 'nama_jurusan' => 'Rekayasa Perangkat Lunak', 'kuota' => 72],
            ['kode_jurusan' => 'TJKT', 'nama_jurusan' => 'Teknik Jaringan Komputer dan Telekomunikasi', 'kuota' => 72],
            ['kode_jurusan' => 'AKL', 'nama_jurusan' => 'Akuntansi dan Keuangan Lembaga', 'kuota' => 72],
            ['kode_jurusan' => 'DKV', 'nama_jurusan' => 'Desain Komunikasi Visual', 'kuota' => 72],
            ['kode_jurusan' => 'MPLB', 'nama_jurusan' => 'Manajemen Perkantoran dan Layanan Bisnis', 'kuota' => 72],
            ['kode_jurusan' => 'TO', 'nama_jurusan' => 'Teknik Otomotif', 'kuota' => 72],
        ];

        foreach ($jurusan as $j) {
            Major::updateOrCreate(
                ['kode_jurusan' => $j['kode_jurusan']],
                ['nama_jurusan' => $j['nama_jurusan'], 'kuota' => $j['kuota'], 'is_active' => true]
            );
        }
    }
}
