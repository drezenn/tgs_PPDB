<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Siswa Baru</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen py-10">
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Form Pendaftaran Siswa Baru</h2>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- 1. DATA SISWA -->
            <div class="border-b pb-4">
                <h3 class="text-lg font-semibold mb-4 text-blue-600">1. Data Siswa</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="w-full border rounded p-2 mt-1">
                        @error('nama_lengkap') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NISN</label>
                        <input type="text" name="nisn" value="{{ old('nisn') }}" class="w-full border rounded p-2 mt-1">
                        @error('nisn') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">NIK</label>
                        <input type="text" name="nik" value="{{ old('nik') }}" class="w-full border rounded p-2 mt-1">
                        @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="w-full border rounded p-2 mt-1">
                        @error('tempat_lahir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full border rounded p-2 mt-1">
                        @error('tanggal_lahir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full border rounded p-2 mt-1">
                            <option value="">-- Pilih --</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Agama</label>
                        <select name="agama" class="w-full border rounded p-2 mt-1">
                            <option value="">-- Pilih --</option>
                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                        @error('agama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. HP Siswa</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" class="w-full border rounded p-2 mt-1">
                        @error('no_hp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Sekolah Asal</label>
                        <input type="text" name="sekolah_asal" value="{{ old('sekolah_asal') }}" class="w-full border rounded p-2 mt-1">
                        @error('sekolah_asal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                        <textarea name="alamat_lengkap" rows="3" class="w-full border rounded p-2 mt-1">{{ old('alamat_lengkap') }}</textarea>
                        @error('alamat_lengkap') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- 2. DATA ORANG TUA -->
            <div class="border-b pb-4">
                <h3 class="text-lg font-semibold mb-4 text-blue-600">2. Data Orang Tua</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Ayah</label>
                        <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}" class="w-full border rounded p-2 mt-1">
                        @error('nama_ayah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}" class="w-full border rounded p-2 mt-1">
                        @error('pekerjaan_ayah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Ibu</label>
                        <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}" class="w-full border rounded p-2 mt-1">
                        @error('nama_ibu') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}" class="w-full border rounded p-2 mt-1">
                        @error('pekerjaan_ibu') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">No. HP Orang Tua</label>
                        <input type="text" name="no_hp_orangtua" value="{{ old('no_hp_orangtua') }}" class="w-full border rounded p-2 mt-1">
                        @error('no_hp_orangtua') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Penghasilan Orang Tua</label>
                        <input type="text" name="penghasilan_orangtua" value="{{ old('penghasilan_orangtua') }}" class="w-full border rounded p-2 mt-1">
                        @error('penghasilan_orangtua') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- 3. PILIHAN JURUSAN -->
            <div class="border-b pb-4">
                <h3 class="text-lg font-semibold mb-4 text-blue-600">3. Pilihan Jurusan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pilihan Jurusan 1</label>
                        <select name="pilihan_1" class="w-full border rounded p-2 mt-1">
                            <option value="">-- Pilih Jurusan Utama --</option>
                            @foreach ($majors as $m)
                                <option value="{{ $m->id }}" {{ old('pilihan_1') == $m->id ? 'selected' : '' }}>
                                    {{ $m->nama_jurusan }} ({{ $m->kode_jurusan }})
                                </option>
                            @endforeach
                        </select>
                        @error('pilihan_1') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pilihan Jurusan 2</label>
                        <select name="pilihan_2" class="w-full border rounded p-2 mt-1">
                            <option value="">-- Pilih Jurusan Cadangan --</option>
                            @foreach ($majors as $m)
                                <option value="{{ $m->id }}" {{ old('pilihan_2') == $m->id ? 'selected' : '' }}>
                                    {{ $m->nama_jurusan }} ({{ $m->kode_jurusan }})
                                </option>
                            @endforeach
                        </select>
                        @error('pilihan_2') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- 4. UPLOAD BERKAS -->
            <div class="pb-4">
                <h3 class="text-lg font-semibold mb-4 text-blue-600">4. Upload Berkas</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kartu Keluarga (KK) <span class="text-red-500">*wajib</span></label>
                        <input type="file" name="berkas_kk" class="w-full border rounded p-2 mt-1">
                        @error('berkas_kk') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Rapor <span class="text-red-500">*wajib</span></label>
                        <input type="file" name="berkas_rapor" class="w-full border rounded p-2 mt-1">
                        @error('berkas_rapor') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ijazah (opsional)</label>
                        <input type="file" name="berkas_ijazah" class="w-full border rounded p-2 mt-1">
                        @error('berkas_ijazah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pasfoto (opsional)</label>
                        <input type="file" name="berkas_pasfoto" class="w-full border rounded p-2 mt-1">
                        @error('berkas_pasfoto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded font-semibold hover:bg-blue-700 transition">
                Kirim Pendaftaran
            </button>
        </form>
    </div>
</body>
</html>