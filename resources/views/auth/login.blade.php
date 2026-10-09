<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | PPDB</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Outfit', system-ui, sans-serif; }

        /* Pola kotak di panel kanan */
        .grid-pattern {
            background-color: #ece9fb;
            background-image:
                linear-gradient(rgba(106, 13, 255, .08) 1px, transparent 1px),
                linear-gradient(90deg, rgba(106, 13, 255, .08) 1px, transparent 1px);
            background-size: 62px 62px;
        }
    </style>
</head>

<body class="min-h-screen bg-white text-slate-900">

<div class="min-h-screen grid lg:grid-cols-2">

    <!-- ===================== KIRI : FORM LOGIN ===================== -->
    <div class="flex items-center justify-center px-6 py-12 bg-white">
        <div class="w-full max-w-md">

            <!-- Logo -->
            <div class="flex items-center gap-3 mb-6">
                <div class="w-11 h-11 rounded-xl bg-[#6a0dff] flex items-center justify-center">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12.5l4.5 4.5L19 7.5" />
                    </svg>
                </div>
                <span class="text-lg font-bold">PPDB</span>
            </div>

            <!-- Judul -->
            <h1 class="text-4xl font-bold leading-tight">Masuk</h1>
            <p class="text-slate-500 mt-2 mb-8">
                Sistem Penerimaan Peserta Didik Baru — SMK [NAMA SEKOLAH]
            </p>

            <!-- Form (satu form untuk 2 role: role ditentukan otomatis dari akun) -->
            <form action="{{ route('login') }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div class="mb-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                        <p class="font-semibold">Login gagal:</p>
                        <ul class="mt-1 list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('status'))
                    <div class="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Email -->
                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium mb-2">
                        Email<span class="text-red-500">*</span>
                    </label>
                    <input id="email" type="email" name="email" required placeholder="nama@email.com" value="{{ old('email') }}"
                           class="w-full px-4 py-3.5 bg-white border border-slate-200 rounded-xl
                                  placeholder-slate-400 focus:outline-none focus:border-[#6a0dff]
                                  focus:ring-4 focus:ring-[#6a0dff]/15 transition">
                </div>

                <!-- Kata sandi -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium mb-2">
                        Kata sandi<span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required placeholder="Masukkan kata sandi"
                               class="w-full px-4 py-3.5 pr-20 bg-white border border-slate-200 rounded-xl
                                      placeholder-slate-400 focus:outline-none focus:border-[#6a0dff]
                                      focus:ring-4 focus:ring-[#6a0dff]/15 transition">
                        <button type="button" id="togglePw"
                                class="absolute right-4 top-1/2 -translate-y-1/2 text-sm text-slate-500 hover:text-[#6a0dff]">
                            Lihat
                        </button>
                    </div>
                </div>

                <!-- Ingat saya + lupa -->
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2 text-sm text-slate-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded accent-[#6a0dff]">
                        Ingat saya
                    </label>
                    <a href="#" class="text-sm text-[#6a0dff] hover:underline">Lupa kata sandi?</a>
                </div>

                <!-- Tombol -->
                <button type="submit"
                        class="w-full py-3.5 bg-[#6a0dff] hover:brightness-110 text-white font-semibold
                               rounded-xl transition shadow-lg shadow-[#6a0dff]/25">
                    Masuk ke Dashboard
                </button>
            </form>

            <!-- ========== PENDAFTARAN SISWA (di bawah login) ========== -->
            <div class="mt-8 rounded-2xl bg-[#efe9ff] p-5 text-center">
                <p class="font-semibold">Belum punya akun?</p>
                <p class="text-sm text-slate-600 mt-1">
                    Calon siswa baru silakan daftar terlebih dahulu untuk mengikuti PPDB.
                </p>
                <a href="/pendaftaran"
                   class="mt-4 inline-flex w-full items-center justify-center py-3.5 bg-white
                          border-2 border-[#6a0dff] text-[#6a0dff] hover:bg-[#6a0dff] hover:text-white
                          font-semibold rounded-xl transition">
                    Daftar Siswa Baru
                </a>
            </div>

            <p class="text-center text-xs text-slate-400 mt-8">
                © 2026 SMK [NAMA SEKOLAH] · Sistem PPDB Online
            </p>
        </div>
    </div>

    <!-- ===================== KANAN : PANEL INFO ===================== -->
    <div class="hidden lg:flex relative grid-pattern items-center justify-center p-12 overflow-hidden">
        <!-- kotak aksen -->
        <div class="absolute top-[62px] right-[124px] w-[62px] h-[62px] bg-[#6a0dff]/10"></div>
        <div class="absolute bottom-[62px] left-[124px] w-[62px] h-[62px] bg-[#6a0dff]/10"></div>

        <div class="relative text-center max-w-sm">
            <h2 class="text-3xl font-bold">PPDB</h2>
            <p class="mt-3 text-lg leading-relaxed text-slate-600">
                Pendaftaran Peserta Didik Baru Online — daftar, unggah berkas,
                pantau verifikasi, dan lihat hasil seleksi dalam satu tempat.
            </p>
            <span class="inline-flex items-center gap-2 mt-6 px-4 py-2 bg-white rounded-full
                         text-sm font-semibold text-[#6a0dff] shadow">
                <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                PPDB Tahun Ajaran 2026/2027
            </span>
        </div>
    </div>

</div>

<script>
    // Tampilkan / sembunyikan kata sandi
    const pw = document.getElementById('password');
    const btn = document.getElementById('togglePw');
    btn.addEventListener('click', () => {
        const hidden = pw.type === 'password';
        pw.type = hidden ? 'text' : 'password';
        btn.textContent = hidden ? 'Sembunyi' : 'Lihat';
    });
</script>

</body>
</html>