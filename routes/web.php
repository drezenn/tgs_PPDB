<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendaftaranController; // 1. Ditambahkan di paling atas
use App\Models\Registration;


Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::get('/dashboard', function () {
    // 1. Ambil 10 pendaftar terbaru + relasinya sekaligus (biar hemat query)
    $regs = Registration::with(['studentProfile', 'majorSelections.major'])
        ->latest()->take(10)->get();

    // 2. Ubah bentuknya agar cocok dengan yang dibaca dashboard.blade.php:117-118
    //    ($p->no_pendaftaran, $p->nama, $p->jalur, $p->asal_sekolah, $p->status)
    $pendaftar = $regs->map(fn ($r) => (object) [
        'no_pendaftaran' => $r->nomor_pendaftaran,
        'nama'           => $r->studentProfile?->nama_lengkap ?? '-',
        'jalur'          => $r->majorSelections->firstWhere('pilihan_ke', 1)?->major?->nama_jurusan ?? '-',
        'asal_sekolah'   => $r->studentProfile?->sekolah_asal ?? '-',
        'status'         => $r->status,
    ]);

    // 3. Angka kartu ringkasan dihitung dari database (sebelumnya 0 semua)
    return view('dashboard', [
        'ringkasan' => [
            'total'         => ['nilai' => Registration::count(), 'trend' => 0],
            'menunggu'      => ['nilai' => Registration::where('status', 'submitted')->count(), 'trend' => 0],
            'terverifikasi' => ['nilai' => Registration::where('status', 'verified')->count(), 'trend' => 0],
            'ditolak'       => ['nilai' => Registration::where('status', 'rejected')->count(), 'trend' => 0],
        ],
        'pendaftar' => $pendaftar,
        'harian' => ['labels' => [], 'data' => []],
        'jalur' => [],
        'kuota' => [],
        'jadwal' => [],
    ]);
})->middleware('auth')->name('dashboard');

// 2. Ditambahkan di atas require auth.php
Route::get('/pendaftaran', [PendaftaranController::class, 'create'])->name('pendaftaran.create');
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
Route::get('/pendaftaran/sukses/{registration:nomor_pendaftaran}', [PendaftaranController::class, 'sukses'])
    ->name('pendaftaran.sukses');

require __DIR__.'/auth.php';