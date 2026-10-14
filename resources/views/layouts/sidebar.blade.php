@php
    $url    = fn ($r) => Route::has($r) ? route($r) : '#';
    $active = fn ($r) => request()->routeIs($r . '*');

    // Menu teks saja (tanpa data / tanpa query) mengikuti flowchart:
    // [SISWA/CALON SISWA] -> [PANITIA] -> [ADMIN] -> Pengumuman -> Selesai.
    // Semua link sengaja '#' (route tidak ada -> fallback '#') sampai backend diisi.
    $menu = [
        'Utama' => [
            ['title' => 'Dashboard', 'icon' => 'layout-dashboard', 'route' => 'dashboard'],
        ],
        'Siswa / Calon Siswa' => [
            ['title' => 'Alur Pendaftaran', 'icon' => 'users', 'children' => [
                ['title' => 'Mulai Pendaftaran', 'route' => '#'],
                ['title' => 'Isi Data Diri & Orang Tua', 'route' => '#'],
                ['title' => 'Pilih Jurusan 1 & 2', 'route' => '#'],
                ['title' => 'Upload Berkas / Dokumen', 'route' => '#'],
                ['title' => 'Submit Pendaftaran', 'route' => '#', 'hint' => 'Status: SUBMITTED'],
                ['title' => 'Lihat Pengumuman', 'route' => '#', 'hint' => 'Selesai'],
            ]],
        ],
        'Panitia' => [
            ['title' => 'Dashboard Verifikasi', 'icon' => 'layout-dashboard', 'route' => 'dashboard'],
            ['title' => 'Periksa Berkas & Data', 'icon' => 'file-check-2', 'route' => '#', 'hint' => 'Apakah Valid?'],
            ['title' => 'Catat Revisi', 'icon' => 'file-x-2', 'route' => '#', 'hint' => 'Status: REJECTED'],
            ['title' => 'Ubah Status Berkas', 'icon' => 'badge-check', 'route' => '#', 'hint' => 'Status: VERIFIED'],
        ],
        'Admin' => [
            ['title' => 'Dashboard Admin', 'icon' => 'shield-check', 'route' => 'dashboard'],
            ['title' => 'Cek Kuota & Ranking Jurusan', 'icon' => 'list-ordered', 'route' => '#'],
            ['title' => 'Penetapan Hasil Seleksi', 'icon' => 'megaphone', 'children' => [
                ['title' => 'Lolos Kuota', 'route' => '#', 'hint' => 'Status: ACCEPTED'],
                ['title' => 'Tidak Lolos Kuota', 'route' => '#', 'hint' => 'Status: REJECTED'],
            ]],
            ['title' => 'Pengumuman ke Siswa', 'icon' => 'message-circle', 'route' => '#', 'hint' => 'Selesai'],
        ],
    ];

    $linkBase = 'group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors';
    $linkOn   = 'bg-brand-600 text-white shadow-sm';
    $linkOff  = 'text-slate-300 hover:bg-navy-800 hover:text-white';
@endphp

{{-- Overlay (mobile) --}}
<div x-show="mobileOpen" x-cloak x-transition.opacity @click="mobileOpen = false"
     class="fixed inset-0 z-40 bg-slate-900/60 lg:hidden"></div>

<aside class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col bg-navy-900 text-slate-300 transition-all duration-300"
       :class="[mini ? 'lg:w-20' : 'lg:w-72', mobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0']"
       aria-label="Navigasi utama">

    {{-- Logo --}}
    <div class="flex h-16 shrink-0 items-center gap-3 border-b border-white/10 px-4" :class="mini && 'lg:justify-center'">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-brand-600 text-white">
            <i data-lucide="graduation-cap" class="h-5 w-5"></i>
        </div>
        <div x-show="!mini" class="min-w-0 flex-1">
            <p class="truncate text-base font-bold leading-tight text-white">PPDB Online</p>
            <p class="truncate text-xs text-slate-400">SMA Negeri 1 Contoh</p>
        </div>
        <button x-show="!mini" @click="mobileOpen = false" class="rounded-md p-1.5 text-slate-400 hover:bg-navy-800 hover:text-white lg:hidden" aria-label="Tutup menu">
            <i data-lucide="x" class="h-5 w-5"></i>
        </button>
    </div>

    {{-- Status periode --}}
    <div x-show="!mini" class="mx-4 mt-4 rounded-lg border border-white/10 bg-navy-800 px-3 py-2.5">
        <div class="flex items-center justify-between text-xs">
            <span class="text-slate-400">Gelombang 1 TA 2026/2027</span>
            <span class="flex items-center gap-1.5 font-medium text-emerald-400">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>Dibuka
            </span>
        </div>
        <p class="mt-1 text-xs text-slate-400">Ditutup 30 Juni 2026</p>
    </div>

    {{-- Menu --}}
    <nav class="scroll-thin flex-1 space-y-5 overflow-y-auto px-3 py-4">
        @foreach ($menu as $group => $items)
            <div>
                <p x-show="!mini" class="mb-1.5 px-3 text-xs font-semibold text-slate-500">{{ $group }}</p>
                <div x-show="mini" class="mx-3 mb-2 border-t border-white/10"></div>

                <ul class="space-y-1">
                    @foreach ($items as $item)
                        @if (empty($item['children']))
                            @php $on = $active($item['route']); @endphp
                            <li>
                                <a href="{{ $url($item['route']) }}" title="{{ $item['title'] }}"
                                   class="{{ $linkBase }} {{ $on ? $linkOn : $linkOff }}" :class="mini && 'lg:justify-center'">
                                    <i data-lucide="{{ $item['icon'] }}" class="h-5 w-5 shrink-0"></i>
                                    <span x-show="!mini" class="min-w-0 flex-1">
                                        <span class="block truncate">{{ $item['title'] }}</span>
                                        @if (!empty($item['hint']))
                                            <span class="block truncate text-xs font-normal text-slate-500">{{ $item['hint'] }}</span>
                                        @endif
                                    </span>
                                    @if (!empty($item['badge']))
                                        <span x-show="!mini" class="rounded-full bg-rose-500 px-2 py-0.5 text-xs font-semibold text-white">{{ $item['badge'] }}</span>
                                    @endif
                                </a>
                            </li>
                        @else
                            @php $on = collect($item['children'])->contains(fn ($c) => $active($c['route'])); @endphp
                            <li x-data="{ open: {{ $on ? 'true' : 'false' }} }">
                                <button type="button" title="{{ $item['title'] }}"
                                        @click="mini ? (collapsed = false, open = true) : open = !open"
                                        class="{{ $linkBase }} w-full {{ $on ? 'bg-navy-800 text-white' : $linkOff }}" :class="mini && 'lg:justify-center'"
                                        :aria-expanded="open">
                                    <i data-lucide="{{ $item['icon'] }}" class="h-5 w-5 shrink-0"></i>
                                    <span x-show="!mini" class="min-w-0 flex-1 text-left">
                                        <span class="block truncate">{{ $item['title'] }}</span>
                                        @if (!empty($item['hint']))
                                            <span class="block truncate text-xs font-normal text-slate-500">{{ $item['hint'] }}</span>
                                        @endif
                                    </span>
                                    <span x-show="!mini" class="transition-transform duration-200" :class="open && 'rotate-180'">
                                        <i data-lucide="chevron-down" class="h-4 w-4"></i>
                                    </span>
                                </button>

                                <ul x-show="open && !mini" x-cloak x-transition.opacity.duration.150ms
                                    class="ml-5 mt-1 space-y-0.5 border-l border-white/10 pl-3">
                                    @foreach ($item['children'] as $child)
                                        <li>
                                            <a href="{{ $url($child['route']) }}"
                                               class="block rounded-md px-3 py-2 text-sm transition-colors {{ $active($child['route']) ? 'bg-brand-600/20 font-medium text-white' : 'text-slate-400 hover:text-white' }}">
                                                 {{ $child['title'] }}
                                                 @if (!empty($child['hint']))
                                                     <span class="block text-xs text-slate-500">{{ $child['hint'] }}</span>
                                                 @endif
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endforeach
    </nav>

    {{-- Profil singkat --}}
    <div class="shrink-0 border-t border-white/10 p-3">
        <div class="flex items-center gap-3 rounded-lg p-2" :class="mini && 'lg:justify-center'">
            <img class="h-9 w-9 shrink-0 rounded-full bg-slate-600 object-cover"
                 src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin PPDB') }}&background=2563eb&color=fff" alt="">
            <div x-show="!mini" class="min-w-0 flex-1">
                <p class="truncate text-sm font-semibold text-white">{{ auth()->user()->name ?? 'Admin PPDB' }}</p>
                <p class="truncate text-xs text-slate-400">{{ ucfirst(auth()->user()->role ?? 'Panitia') }} PPDB</p>
            </div>
            <form x-show="!mini" method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}">
                @csrf
                <button type="submit" class="rounded-md p-2 text-slate-400 hover:bg-navy-800 hover:text-white" title="Keluar" aria-label="Keluar">
                    <i data-lucide="log-out" class="h-4 w-4"></i>
                </button>
            </form>
        </div>
    </div>
</aside>