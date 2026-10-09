<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center py-10">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow text-center">
        <div class="text-green-500 text-5xl mb-4">✓</div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Pendaftaran Berhasil!</h2>
        <p class="text-sm text-gray-600 mb-6">Simpan atau catat nomor pendaftaran Anda untuk pengecekan status.</p>

        <div class="bg-gray-50 border p-4 rounded mb-6 text-left space-y-2">
            <div>
                <span class="text-xs text-gray-500 block">Nomor Pendaftaran</span>
                <span class="text-lg font-bold text-blue-600">{{ $registration->nomor_pendaftaran }}</span>
            </div>
            <div>
                <span class="text-xs text-gray-500 block">Nama Lengkap</span>
                <span class="font-medium text-gray-800">{{ $registration->studentProfile->nama_lengkap ?? '-' }}</span>
            </div>
            <div>
                <span class="text-xs text-gray-500 block">Pilihan Jurusan</span>
                <ul class="list-disc pl-5 text-sm text-gray-700">
                    @foreach ($registration->majorSelections as $ms)
                        <li>Pilihan {{ $ms->pilihan_ke }}: {{ $ms->major->nama_jurusan }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <a href="/" class="inline-block w-full bg-blue-600 text-white py-2 rounded font-semibold hover:bg-blue-700 transition">
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>