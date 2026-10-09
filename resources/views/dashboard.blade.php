@extends('layouts.admin')

@section('title', 'Dashboard')

@section('actions')
    <a href="#" class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3.5 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
        <i data-lucide="file-down" class="h-4 w-4"></i>Ekspor laporan
    </a>
    <a href="#" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-3.5 py-2 text-sm font-semibold text-white hover:bg-brand-700">
        <i data-lucide="user-plus" class="h-4 w-4"></i>Tambah pendaftar
    </a>
@endsection

@section('content')
@php
    // Data utama dikirim dari route /dashboard di routes/web.php:
    // $ringkasan, $pendaftar, $harian, $jalur, $kuota, $jadwal
    $cards = [
        ['Total pendaftar',     'users',       'bg-brand-50 text-brand-600',     'total',         true],
        ['Menunggu verifikasi', 'hourglass',   'bg-amber-50 text-amber-600',     'menunggu',      false],
        ['Terverifikasi',       'badge-check', 'bg-emerald-50 text-emerald-600', 'terverifikasi', true],
        ['Ditolak',             'file-x-2',    'bg-rose-50 text-rose-600',       'ditolak',       false],
    ];
    $stats = collect($cards)->map(function ($c) use ($ringkasan) {
        [$label, $icon, $tone, $key, $naikBagus] = $c;
        $d = $ringkasan[$key] ?? ['nilai' => 0, 'trend' => 0];
        return [
            $label, number_format($d['nilai'] ?? 0, 0, ',', '.'), $icon, $tone,
            (($d['trend'] ?? 0) > 0 ? '+' : '') . ($d['trend'] ?? 0) . '%',
            ((($d['trend'] ?? 0) >= 0) === $naikBagus) ? 'text-emerald-600' : 'text-rose-600',
        ];
    })->all();

    // Warna badge + label Indonesia untuk status pendaftaran
    $badge = [
        'submitted' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
        'verified'  => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        'rejected'  => 'bg-rose-50 text-rose-700 ring-rose-600/20',
        'accepted'  => 'bg-brand-50 text-brand-700 ring-brand-600/20',
    ];
    $labelStatus = [
        'submitted' => 'Menunggu',
        'verified'  => 'Terverifikasi',
        'rejected'  => 'Ditolak',
        'accepted'  => 'Diterima',
    ];

    $aksi = [
        ['Verifikasi berkas', 'file-check-2', ($ringkasan['menunggu']['nilai'] ?? 0) . ' menunggu'], ['Cetak kartu peserta', 'printer', 'Per pendaftar'],
        ['Kirim WhatsApp', 'message-circle', 'Massal'],       ['Umumkan hasil', 'megaphone', 'Publikasikan'],
    ];
@endphp

{{-- Kartu ringkasan --}}
<section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    @foreach ($stats as [$label, $value, $icon, $tone, $trend, $trendTone])
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <div class="flex items-center justify-between">
                <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
                <span class="flex h-10 w-10 items-center justify-center rounded-lg {{ $tone }}"><i data-lucide="{{ $icon }}" class="h-5 w-5"></i></span>
            </div>
            <p class="mt-3 text-3xl font-bold text-slate-900">{{ $value }}</p>
            <p class="mt-1 text-sm"><span class="font-semibold {{ $trendTone }}">{{ $trend }}</span> <span class="text-slate-500">dari minggu lalu</span></p>
        </div>
    @endforeach
</section>

{{-- Grafik --}}
<section class="mt-6 grid gap-6 lg:grid-cols-3">
    <div class="rounded-xl border border-slate-200 bg-white p-5 lg:col-span-2">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-slate-900">Pendaftar per hari</h2>
                <p class="text-sm text-slate-500">14 hari terakhir</p>
            </div>
            <select class="rounded-lg border border-slate-200 py-1.5 pl-3 pr-8 text-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                <option>14 hari</option><option>30 hari</option><option>Semua gelombang</option>
            </select>
        </div>
        <div class="h-72"><canvas id="chartHarian"></canvas></div>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-5">
        <h2 class="font-semibold text-slate-900">Pendaftar per jalur</h2>
        <p class="text-sm text-slate-500">Gelombang 1</p>
        <div class="mx-auto mt-4 h-52 w-52"><canvas id="chartJalur"></canvas></div>
        <ul class="mt-5 space-y-2 text-sm">
            @forelse ($jalur as ['nama' => $n, 'warna' => $c, 'persen' => $p])
                <li class="flex items-center justify-between">
                    <span class="flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-sm" style="background: {{ $c }}"></span>{{ $n }}</span>
                    <span class="font-medium text-slate-900">{{ $p }}%</span>
                </li>
            @empty
                <li class="text-slate-500">Belum ada data.</li>
            @endforelse
        </ul>
    </div>
</section>

{{-- Tabel + sisi kanan --}}
<section class="mt-6 grid gap-6 xl:grid-cols-3">
    <div class="rounded-xl border border-slate-200 bg-white xl:col-span-2">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 p-5">
            <h2 class="font-semibold text-slate-900">Pendaftar terbaru</h2>
            <div class="flex items-center gap-2">
                <div class="relative">
                    <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                    <input type="search" placeholder="Cari pendaftar" class="w-44 rounded-lg border border-slate-200 py-1.5 pl-9 pr-3 text-sm focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20">
                </div>
                <a href="#" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-1.5 text-sm font-medium hover:bg-slate-50"><i data-lucide="sliders-horizontal" class="h-4 w-4"></i>Filter</a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-slate-50 text-slate-500">
                    <tr>
                        <th class="px-5 py-3 font-medium">No. pendaftaran</th>
                        <th class="px-5 py-3 font-medium">Nama</th>
                        <th class="px-5 py-3 font-medium">Jalur</th>
                        <th class="px-5 py-3 font-medium">Asal sekolah</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 text-right font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($pendaftar as $p)
                        @php [$no, $nama, $jalurDaftar, $asal, $status] = [$p->no_pendaftaran, $p->nama, $p->jalur, $p->asal_sekolah, $p->status]; @endphp
                        <tr class="hover:bg-slate-50">
                            <td class="whitespace-nowrap px-5 py-3.5 text-slate-500">{{ $no }}</td>
                            <td class="whitespace-nowrap px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($nama) }}&background=e2e8f0&color=334155" alt="">
                                    <span class="font-medium text-slate-900">{{ $nama }}</span>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-5 py-3.5">{{ $jalurDaftar }}</td>
                            <td class="whitespace-nowrap px-5 py-3.5">{{ $asal }}</td>
                            <td class="whitespace-nowrap px-5 py-3.5">
                                <span class="inline-flex rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $badge[$status] ?? 'bg-slate-50 text-slate-700 ring-slate-600/20' }}">{{ $labelStatus[$status] ?? $status }}</span>
                            </td>
                            <td class="whitespace-nowrap px-5 py-3.5">
                                <div class="flex justify-end gap-1">
                                    <a href="#" class="rounded-md p-1.5 text-slate-500 hover:bg-slate-100 hover:text-brand-600" title="Lihat detail"><i data-lucide="eye" class="h-4 w-4"></i></a>
                                    <a href="#" class="rounded-md p-1.5 text-slate-500 hover:bg-slate-100 hover:text-brand-600" title="Verifikasi"><i data-lucide="badge-check" class="h-4 w-4"></i></a>
                                    <a href="#" class="rounded-md p-1.5 text-slate-500 hover:bg-slate-100 hover:text-rose-600" title="Hapus"><i data-lucide="trash-2" class="h-4 w-4"></i></a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-10 text-center text-slate-500">Belum ada pendaftar. Data akan muncul setelah ada yang mendaftar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="flex items-center justify-between border-t border-slate-100 px-5 py-3 text-sm text-slate-500">
            <p>Menampilkan {{ $pendaftar->count() }} dari {{ number_format($ringkasan['total']['nilai'] ?? 0, 0, ',', '.') }} pendaftar</p>
            <a href="#" class="font-medium text-brand-600 hover:underline">Lihat semua</a>
        </div>
    </div>

    <div class="space-y-6">
        {{-- Kuota --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <h2 class="font-semibold text-slate-900">Kuota per jurusan</h2>
            <div class="mt-4 space-y-4">
                @forelse ($kuota as [$nama, $total, $terisi])
                    @php $pct = $total ? round($terisi / $total * 100) : 0; @endphp
                    <div>
                        <div class="mb-1.5 flex justify-between text-sm">
                            <span class="font-medium text-slate-700">{{ $nama }}</span>
                            <span class="text-slate-500">{{ $terisi }} / {{ $total }}</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-100">
                            <div class="h-2 rounded-full {{ $pct >= 95 ? 'bg-rose-500' : 'bg-brand-600' }}" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-500">Belum ada data kuota.</p>
                @endforelse
            </div>
        </div>

        {{-- Jadwal --}}
        <div class="rounded-xl border border-slate-200 bg-white p-5">
            <h2 class="font-semibold text-slate-900">Jadwal PPDB</h2>
            <ol class="mt-4 space-y-4">
                @forelse ($jadwal as $i => [$judul, $tgl, $st])
                    <li class="relative flex gap-3">
                        @if (!$loop->last)<span class="absolute left-[11px] top-6 h-full w-px bg-slate-200"></span>@endif
                        <span class="relative z-10 flex h-6 w-6 shrink-0 items-center justify-center rounded-full
                            {{ $st === 'done' ? 'bg-emerald-500 text-white' : ($st === 'now' ? 'bg-brand-600 text-white' : 'border-2 border-slate-300 bg-white') }}">
                            @if ($st === 'done')<i data-lucide="check" class="h-3.5 w-3.5"></i>@endif
                            @if ($st === 'now')<i data-lucide="loader" class="h-3.5 w-3.5"></i>@endif
                        </span>
                        <div>
                            <p class="text-sm font-medium {{ $st === 'next' ? 'text-slate-500' : 'text-slate-900' }}">{{ $judul }}</p>
                            <p class="text-xs text-slate-500">{{ $tgl }}</p>
                        </div>
                    </li>
                @empty
                    <li class="text-sm text-slate-500">Belum ada jadwal.</li>
                @endforelse
            </ol>
        </div>
    </div>
</section>

{{-- Aksi cepat --}}
<section class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    @foreach ($aksi as [$judul, $icon, $ket])
        <a href="#" class="flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-4 transition-colors hover:border-brand-500 hover:bg-brand-50/40">
            <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-slate-100 text-slate-600"><i data-lucide="{{ $icon }}" class="h-5 w-5"></i></span>
            <span>
                <span class="block text-sm font-semibold text-slate-900">{{ $judul }}</span>
                <span class="block text-xs text-slate-500">{{ $ket }}</span>
            </span>
        </a>
    @endforeach
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    Chart.defaults.font.family = '"Plus Jakarta Sans", sans-serif';
    Chart.defaults.color = '#64748b';

    new Chart(document.getElementById('chartHarian'), {
        type: 'line',
        data: {
            labels: @json($harian['labels'] ?? []),
            datasets: [{
                label: 'Pendaftar',
                data: @json($harian['data'] ?? []),
                borderColor: '#2563eb', backgroundColor: 'rgba(37,99,235,.08)',
                fill: true, tension: .35, pointRadius: 3, pointBackgroundColor: '#2563eb',
            }],
        },
        options: {
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } },
        },
    });

    new Chart(document.getElementById('chartJalur'), {
        type: 'doughnut',
        data: { labels: @json(collect($jalur)->pluck('nama')),
                datasets: [{ data: @json(collect($jalur)->pluck('jumlah')), backgroundColor: @json(collect($jalur)->pluck('warna')), borderWidth: 0 }] },
        options: { maintainAspectRatio: false, cutout: '68%', plugins: { legend: { display: false } } },
    });
</script>
@endpush
