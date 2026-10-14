<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pendaftaran') - PPDB Online</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Samakan token dengan layouts/admin.blade.php --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                    colors: {
                        brand: {
                            50: '#eff6ff', 100: '#dbeafe', 200: '#bfdbfe', 500: '#3b82f6',
                            600: '#2563eb', 700: '#1d4ed8', 900: '#1e3a8a',
                        },
                        navy: { 800: '#14233a', 900: '#0f1b2d' },
                    },
                },
            },
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>[x-cloak] { display: none !important; }</style>
    @stack('styles')
</head>

<body class="min-h-full bg-slate-100 font-sans text-slate-700 antialiased">

    {{-- Header publik (versi ramping dari layouts/header.blade.php) --}}
    <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur">
        <div class="mx-auto flex h-16 max-w-5xl items-center gap-3 px-4 sm:px-6">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-600 text-white">
                <i data-lucide="graduation-cap" class="h-5 w-5"></i>
            </div>
            <div class="min-w-0 flex-1">
                <p class="truncate text-base font-bold leading-tight text-slate-900">PPDB Online</p>
                <p class="truncate text-xs text-slate-500">SMA Negeri 1 Contoh</p>
            </div>
            <span class="hidden items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 sm:inline-flex">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                Gelombang 1 TA 2026/2027 Dibuka
            </span>
            <a href="{{ Route::has('login') ? route('login') : '#' }}" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                <i data-lucide="log-in" class="h-4 w-4"></i><span class="hidden sm:inline">Login Panitia</span>
            </a>
        </div>
    </header>

    <main class="mx-auto w-full max-w-4xl px-4 py-8 sm:px-6">
        {{-- Hero --}}
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-bold text-slate-900 sm:text-3xl">@yield('title', 'Formulir Pendaftaran Siswa Baru')</h1>
            <p class="mx-auto mt-2 max-w-2xl text-sm text-slate-500">
                @yield('subtitle', 'Lengkapi 4 langkah di bawah: Data Siswa, Data Orang Tua, Pilihan Jurusan (RPL, TJKT, AKL, DKV, MPLB, TO), dan Upload Berkas.')
            </p>
        </div>

        @yield('content')
    </main>

    <footer class="border-t border-slate-200 bg-white px-4 py-4 text-center text-sm text-slate-500">
        <p>&copy; {{ date('Y') }} PPDB Online — SMA Negeri 1 Contoh. Ditutup 30 Juni 2026.</p>
    </footer>

    <script>lucide.createIcons();</script>
    @stack('scripts')
</body>
</html>
