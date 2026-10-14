@extends('layouts.daftar')

@section('title', 'Pendaftaran Berhasil')
@section('subtitle', 'Simpan nomor pendaftaran Anda untuk pengecekan status ke Panitia.')

@section('content')
<div class="mx-auto max-w-md rounded-xl border border-slate-200 bg-white p-8 text-center shadow-sm">
    <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
        <i data-lucide="check-circle-2" class="h-8 w-8"></i>
    </span>
    <h2 class="mt-4 text-2xl font-bold text-slate-900">Pendaftaran Berhasil!</h2>
    <p class="mt-1 text-sm text-slate-500">Status Anda sekarang <span class="inline-flex rounded-md bg-amber-50 px-2 py-0.5 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-600/20">SUBMITTED — Menunggu Verifikasi</span></p>

    <div class="mt-6 rounded-xl border border-slate-200 bg-slate-50 p-4 text-left">
        <div class="border-b border-slate-200 pb-3">
            <span class="block text-xs text-slate-500">Nomor Pendaftaran</span>
            <span class="text-lg font-bold text-brand-700">{{ $registration->nomor_pendaftaran }}</span>
        </div>
        <div class="space-y-2 pt-3 text-sm">
            <div>
                <span class="block text-xs text-slate-500">Nama Lengkap</span>
                <span class="font-semibold text-slate-900">{{ $registration->studentProfile->nama_lengkap ?? '-' }}</span>
            </div>
            <div>
                <span class="block text-xs text-slate-500">Pilihan Jurusan</span>
                <ul class="mt-1 space-y-1">
                    @foreach ($registration->majorSelections as $ms)
                        <li class="flex items-center gap-2 text-slate-700">
                            <i data-lucide="blocks" class="h-4 w-4 text-brand-600"></i>
                            Pilihan {{ $ms->pilihan_ke }}: <span class="font-medium text-slate-900">{{ $ms->major->kode_jurusan ?? '' }} — {{ $ms->major->nama_jurusan ?? '-' }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="mt-6 grid gap-2">
        <a href="{{ route('pendaftaran.create') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-brand-600 px-3.5 py-2.5 text-sm font-semibold text-white hover:bg-brand-700">
            <i data-lucide="plus" class="h-4 w-4"></i>Daftar Lagi
        </a>
        <a href="/" class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3.5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
