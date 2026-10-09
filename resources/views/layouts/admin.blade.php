<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - PPDB Online</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Produksi: ganti CDN Tailwind dengan @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
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

    <style>
        [x-cloak] { display: none !important; }
        .scroll-thin::-webkit-scrollbar { width: 6px; }
        .scroll-thin::-webkit-scrollbar-thumb { background: #334155; border-radius: 999px; }
    </style>
    <script>
        function layout() {
            return {
                mobileOpen: false,
                collapsed: localStorage.getItem('sb-collapsed') === '1',
                desktop: window.innerWidth >= 1024,
                get mini() { return this.collapsed && this.desktop; },
                toggle() {
                    if (this.desktop) {
                        this.collapsed = !this.collapsed;
                        localStorage.setItem('sb-collapsed', this.collapsed ? '1' : '0');
                    } else {
                        this.mobileOpen = !this.mobileOpen;
                    }
                },
            }
        }
    </script>
    @stack('styles')
</head>

<body class="h-full bg-slate-100 font-sans text-slate-700 antialiased"
      x-data="layout()"
      @resize.window="desktop = window.innerWidth >= 1024; if (desktop) mobileOpen = false"
      @keydown.escape.window="mobileOpen = false">

    @include('layouts.sidebar')

    <div class="min-h-screen transition-[padding] duration-300" :class="mini ? 'lg:pl-20' : 'lg:pl-72'">

        @include('layouts.header')

        <main class="px-4 py-6 sm:px-6 lg:px-8">

            {{-- Judul halaman --}}
            <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">@yield('title', 'Dashboard')</h1>
                    <nav class="mt-1 flex items-center gap-1.5 text-sm text-slate-500" aria-label="Breadcrumb">
                        <a href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : '#' }}" class="hover:text-brand-600">Beranda</a>
                        <i data-lucide="chevron-right" class="h-3.5 w-3.5"></i>
                        <span class="text-slate-700">@yield('breadcrumb', View::yieldContent('title'))</span>
                    </nav>
                </div>
                <div class="flex flex-wrap items-center gap-2">@yield('actions')</div>
            </div>

            {{-- Notifikasi flash --}}
            @php
                $flash = [
                    'success' => ['border-emerald-200 bg-emerald-50 text-emerald-800', 'check-circle-2'],
                    'error'   => ['border-rose-200 bg-rose-50 text-rose-800', 'x-circle'],
                    'warning' => ['border-amber-200 bg-amber-50 text-amber-800', 'alert-triangle'],
                ];
            @endphp
            @foreach ($flash as $type => [$tone, $icon])
                @if (session($type))
                    <div x-data="{ show: true }" x-show="show" x-transition
                         class="mb-5 flex items-start gap-3 rounded-lg border px-4 py-3 text-sm {{ $tone }}">
                        <i data-lucide="{{ $icon }}" class="mt-0.5 h-4 w-4 shrink-0"></i>
                        <p class="flex-1">{{ session($type) }}</p>
                        <button @click="show = false" aria-label="Tutup"><i data-lucide="x" class="h-4 w-4"></i></button>
                    </div>
                @endif
            @endforeach

            @yield('content')
        </main>

        <footer class="border-t border-slate-200 px-4 py-4 text-sm text-slate-500 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center justify-between gap-2">
                <p>&copy; {{ date('Y') }} PPDB Online. Seluruh hak dilindungi.</p>
                <p>Versi 1.0.0</p>
            </div>
        </footer>
    </div>

    <script>lucide.createIcons();</script>
    @stack('scripts')
</body>
</html>