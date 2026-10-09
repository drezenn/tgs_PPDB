@php
    use App\Models\Registration;
    // Angka untuk badge merah di ikon bell
    $menunggu = Registration::where('status', 'submitted')->count();
    // 5 pendaftar terbaru untuk isi dropdown
    $terbaru = Registration::with('studentProfile')->latest()->take(5)->get();
    // Dibentuk dengan kunci yang SAMA persis seperti dummy lama
    // (icon, tone, title, text, time) supaya loop baris 77-88 tidak perlu diubah
    $notifs = $terbaru->map(fn ($r) => [
        'icon' => 'user-plus',
        'tone' => 'bg-brand-50 text-brand-600',
        'title' => 'Pendaftar baru',
        'text' => ($r->studentProfile?->nama_lengkap ?? 'Siswa') . ' — ' . $r->nomor_pendaftaran,
        'time' => ($r->submitted_at ?? $r->created_at)?->diffForHumans() ?? '',
    ])->toArray();
    $user = auth()->user()?->name ?? 'Admin PPDB';
@endphp

<header class="sticky top-0 z-30 flex h-16 items-center gap-3 border-b border-slate-200 bg-white/90 px-4 backdrop-blur sm:px-6 lg:px-8">

    {{-- Buka/tutup sidebar --}}
    <button @click="toggle()" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-900"
            aria-label="Buka atau tutup sidebar" title="Buka atau tutup sidebar">
        <i data-lucide="panel-left" class="h-5 w-5"></i>
    </button>

    {{-- Pencarian --}}
    <div class="relative hidden w-full max-w-md md:block"
         @keydown.window.ctrl.k.prevent="$refs.search.focus()" @keydown.window.meta.k.prevent="$refs.search.focus()">
        <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
        <input x-ref="search" type="search" placeholder="Cari nama, NISN, atau nomor pendaftaran"
               class="w-full rounded-lg border border-slate-200 bg-slate-50 py-2 pl-9 pr-16 text-sm placeholder:text-slate-400 focus:border-brand-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20">
        <kbd class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 rounded border border-slate-200 bg-white px-1.5 py-0.5 text-xs text-slate-400">Ctrl K</kbd>
    </div>

    <div class="ml-auto flex items-center gap-1 sm:gap-2">

        {{-- Tahun ajaran --}}
        <div class="relative hidden sm:block" x-data="{ open: false, ta: '2026/2027' }" @click.outside="open = false" @keydown.escape="open = false">
            <button @click="open = !open" class="flex items-center gap-2 rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                <i data-lucide="calendar-days" class="h-4 w-4 text-slate-500"></i>
                <span x-text="'TA ' + ta"></span>
                <i data-lucide="chevron-down" class="h-4 w-4 text-slate-400"></i>
            </button>
            <div x-show="open" x-cloak x-transition class="absolute right-0 mt-2 w-48 rounded-lg border border-slate-200 bg-white p-1 shadow-lg">
                @foreach (['2026/2027', '2025/2026', '2024/2025'] as $ta)
                    <button @click="ta = '{{ $ta }}'; open = false" class="flex w-full items-center justify-between rounded-md px-3 py-2 text-sm hover:bg-slate-50">
                        {{ $ta }}
                        <i data-lucide="check" class="h-4 w-4 text-brand-600" x-show="ta === '{{ $ta }}'"></i>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Tambah cepat --}}
        <div class="relative" x-data="{ open: false }" @click.outside="open = false" @keydown.escape="open = false">
            <button @click="open = !open" class="flex items-center gap-2 rounded-lg bg-brand-600 px-3 py-2 text-sm font-semibold text-white hover:bg-brand-700">
                <i data-lucide="plus" class="h-4 w-4"></i><span class="hidden sm:inline">Tambah</span>
            </button>
            <div x-show="open" x-cloak x-transition class="absolute right-0 mt-2 w-56 rounded-lg border border-slate-200 bg-white p-1 shadow-lg">
                <a href="#" class="flex items-center gap-3 rounded-md px-3 py-2 text-sm hover:bg-slate-50"><i data-lucide="user-plus" class="h-4 w-4 text-slate-500"></i>Pendaftar baru</a>
                <a href="#" class="flex items-center gap-3 rounded-md px-3 py-2 text-sm hover:bg-slate-50"><i data-lucide="file-up" class="h-4 w-4 text-slate-500"></i>Impor dari Excel</a>
                <a href="#" class="flex items-center gap-3 rounded-md px-3 py-2 text-sm hover:bg-slate-50"><i data-lucide="megaphone" class="h-4 w-4 text-slate-500"></i>Buat pengumuman</a>
            </div>
        </div>
        {{-- Fullscreen --}}
        <button type="button" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-900" aria-label="Layar penuh">
            <i data-lucide="maximize" class="h-5 w-5"></i>
        </button>

        {{-- Notifikasi --}}
        <div class="relative" x-data="{ open: false }" @click.outside="open = false" @keydown.escape="open = false">
            <button @click="open = !open" class="relative rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-900" aria-label="Notifikasi">
                <i data-lucide="bell" class="h-5 w-5"></i>
                @if ($menunggu > 0)
                    <span class="absolute -right-0.5 -top-0.5 flex h-5 min-w-5 items-center justify-center rounded-full bg-rose-500 px-1 text-[11px] font-bold text-white">{{ $menunggu }}</span>
                @else
                    <span class="absolute right-1.5 top-1.5 h-2.5 w-2.5 rounded-full border-2 border-white bg-rose-500"></span>
                @endif
            </button>
            <div x-show="open" x-cloak x-transition
                 class="fixed inset-x-4 top-16 mt-2 rounded-lg border border-slate-200 bg-white shadow-lg sm:absolute sm:inset-x-auto sm:right-0 sm:top-auto sm:w-96">
                <div class="flex items-center justify-between border-b border-slate-100 px-4 py-3">
                    <p class="text-sm font-semibold text-slate-900">Notifikasi</p>
                    <a href="#" class="text-xs font-medium text-brand-600 hover:underline">Tandai semua dibaca</a>
                </div>
                <ul class="max-h-80 divide-y divide-slate-100 overflow-y-auto">
                    @foreach ($notifs as $n)
                        <li>
                            <a href="#" class="flex gap-3 px-4 py-3 hover:bg-slate-50">
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg {{ $n['tone'] }}"><i data-lucide="{{ $n['icon'] }}" class="h-4 w-4"></i></span>
                                <span class="min-w-0">
                                    <span class="block text-sm font-medium text-slate-900">{{ $n['title'] }}</span>
                                    <span class="block text-sm text-slate-500">{{ $n['text'] }}</span>
                                    <span class="mt-0.5 block text-xs text-slate-400">{{ $n['time'] }}</span>
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <a href="#" class="block border-t border-slate-100 px-4 py-3 text-center text-sm font-medium text-brand-600 hover:bg-slate-50">Lihat semua notifikasi</a>
            </div>
        </div>

        <span class="mx-1 hidden h-6 w-px bg-slate-200 sm:block"></span>

        {{-- Profil --}}
        <div class="relative" x-data="{ open: false }" @click.outside="open = false" @keydown.escape="open = false">
            <button @click="open = !open" class="flex items-center gap-2 rounded-lg p-1 hover:bg-slate-100">
                <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode($user) }}&background=2563eb&color=fff" alt="">
                <span class="hidden text-left leading-tight lg:block">
                    <span class="block text-sm font-semibold text-slate-900">{{ $user }}</span>
                    <span class="block text-xs text-slate-500">Administrator</span>
                </span>
                <i data-lucide="chevron-down" class="hidden h-4 w-4 text-slate-400 lg:block"></i>
            </button>
            <div x-show="open" x-cloak x-transition class="absolute right-0 mt-2 w-56 rounded-lg border border-slate-200 bg-white p-1 shadow-lg">
                <div class="border-b border-slate-100 px-3 py-2">
                    <p class="truncate text-sm font-semibold text-slate-900">{{ $user }}</p>
                    <p class="truncate text-xs text-slate-500">{{ auth()->user()?->email ?? 'admin@sekolah.sch.id' }}</p>
                </div>
                <a href="#" class="mt-1 flex items-center gap-3 rounded-md px-3 py-2 text-sm hover:bg-slate-50"><i data-lucide="user" class="h-4 w-4 text-slate-500"></i>Profil saya</a>
                <a href="#" class="flex items-center gap-3 rounded-md px-3 py-2 text-sm hover:bg-slate-50"><i data-lucide="key-round" class="h-4 w-4 text-slate-500"></i>Ubah kata sandi</a>
                <a href="#" class="flex items-center gap-3 rounded-md px-3 py-2 text-sm hover:bg-slate-50"><i data-lucide="life-buoy" class="h-4 w-4 text-slate-500"></i>Pusat bantuan</a>
                <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}" class="mt-1 border-t border-slate-100 pt-1">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-3 rounded-md px-3 py-2 text-sm text-rose-600 hover:bg-rose-50">
                        <i data-lucide="log-out" class="h-4 w-4"></i>Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>