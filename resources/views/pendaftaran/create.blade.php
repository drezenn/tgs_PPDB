@extends('layouts.daftar')

@section('title', 'Formulir Pendaftaran Siswa Baru')
@section('subtitle', 'Lengkapi 4 langkah di bawah: Data Siswa, Data Orang Tua, Pilihan Jurusan, dan Upload Berkas.')

@section('content')
@php
    // Token serasi dashboard/admin: card rounded-xl, input rounded-lg focus brand
    $input = 'w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 placeholder:text-slate-400 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20';
    $label = 'block text-sm font-medium text-slate-700';
    $err = 'mt-1 text-xs text-rose-600';
    $steps = [
        ['1. Data Siswa', 'user', true],
        ['2. Data Ortu', 'users', false],
        ['3. Jurusan', 'blocks', false],
        ['4. Berkas', 'folder-check', false],
    ];
@endphp

{{-- Stepper --}}
<ol class="mb-6 grid grid-cols-2 gap-3 sm:grid-cols-4">
    @foreach ($steps as [$judul, $icon, $on])
        <li class="flex items-center gap-3 rounded-xl border px-3 py-2.5 {{ $on ? 'border-brand-200 bg-brand-50' : 'border-slate-200 bg-white' }}">
            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg {{ $on ? 'bg-brand-600 text-white' : 'bg-slate-100 text-slate-500' }}">
                <i data-lucide="{{ $icon }}" class="h-4 w-4"></i>
            </span>
            <span class="text-sm font-semibold {{ $on ? 'text-brand-700' : 'text-slate-600' }}">{{ $judul }}</span>
        </li>
    @endforeach
</ol>

{{-- Error global serasi flash admin --}}
@if ($errors->any())
    <div class="mb-5 flex items-start gap-3 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800">
        <i data-lucide="x-circle" class="mt-0.5 h-4 w-4 shrink-0"></i>
        <div class="flex-1">
            <p class="font-semibold">Periksa kembali isian Anda:</p>
            <ul class="mt-1 list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
    @csrf

    {{-- 1. DATA SISWA --}}
    <section class="rounded-xl border border-slate-200 bg-white p-5 sm:p-6">
        <div class="mb-4 flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-50 text-brand-600"><i data-lucide="user" class="h-5 w-5"></i></span>
            <div>
                <h3 class="font-semibold text-slate-900">1. Data Siswa</h3>
                <p class="text-xs text-slate-500">Sesuai KK / akta kelahiran</p>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <label class="{{ $label }}">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="cth: Budi Santoso" class="{{ $input }} mt-1">
                @error('nama_lengkap') <p class="{{ $err }}">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="{{ $label }}">NISN</label>
                <input type="text" name="nisn" value="{{ old('nisn') }}" placeholder="10 digit" class="{{ $input }} mt-1">
                @error('nisn') <p class="{{ $err }}">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="{{ $label }}">NIK</label>
                <input type="text" name="nik" value="{{ old('nik') }}" placeholder="16 digit" class="{{ $input }} mt-1">
                @error('nik') <p class="{{ $err }}">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="{{ $label }}">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="{{ $input }} mt-1">
                @error('tempat_lahir') <p class="{{ $err }}">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="{{ $label }}">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="{{ $input }} mt-1">
                @error('tanggal_lahir') <p class="{{ $err }}">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="{{ $label }}">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="{{ $input }} mt-1">
                    <option value="">-- Pilih --</option>
                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin') <p class="{{ $err }}">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="{{ $label }}">Agama</label>
                <select name="agama" class="{{ $input }} mt-1">
                    <option value="">-- Pilih --</option>
                    @foreach (['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $ag)
                        <option value="{{ $ag }}" {{ old('agama') == $ag ? 'selected' : '' }}>{{ $ag }}</option>
                    @endforeach
                </select>
                @error('agama') <p class="{{ $err }}">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="{{ $label }}">No. HP Siswa</label>
                <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="cth: 0812xxxx" class="{{ $input }} mt-1">
                @error('no_hp') <p class="{{ $err }}">{{ $message }}</p> @enderror
            </div>
            <div class="md:col-span-2">
                <label class="{{ $label }}">Sekolah Asal</label>
                <input type="text" name="sekolah_asal" value="{{ old('sekolah_asal') }}" placeholder="cth: SMPN 1 Contoh" class="{{ $input }} mt-1">
                @error('sekolah_asal') <p class="{{ $err }}">{{ $message }}</p> @enderror
            </div>
            <div class="md:col-span-2">
                <label class="{{ $label }}">Alamat Lengkap</label>
                <textarea name="alamat_lengkap" rows="3" placeholder="Jalan, RT/RW, kelurahan, kecamatan" class="{{ $input }} mt-1">{{ old('alamat_lengkap') }}</textarea>
                @error('alamat_lengkap') <p class="{{ $err }}">{{ $message }}</p> @enderror
            </div>
        </div>
    </section>

    {{-- 2. DATA ORANG TUA --}}
    <section class="rounded-xl border border-slate-200 bg-white p-5 sm:p-6">
        <div class="mb-4 flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-50 text-brand-600"><i data-lucide="users" class="h-5 w-5"></i></span>
            <div>
                <h3 class="font-semibold text-slate-900">2. Data Orang Tua</h3>
                <p class="text-xs text-slate-500">Untuk keperluan verifikasi panitia</p>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <label class="{{ $label }}">Nama Ayah</label>
                <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}" class="{{ $input }} mt-1">
                @error('nama_ayah') <p class="{{ $err }}">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="{{ $label }}">Pekerjaan Ayah</label>
                <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah') }}" class="{{ $input }} mt-1">
                @error('pekerjaan_ayah') <p class="{{ $err }}">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="{{ $label }}">Nama Ibu</label>
                <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}" class="{{ $input }} mt-1">
                @error('nama_ibu') <p class="{{ $err }}">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="{{ $label }}">Pekerjaan Ibu</label>
                <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu') }}" class="{{ $input }} mt-1">
                @error('pekerjaan_ibu') <p class="{{ $err }}">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="{{ $label }}">No. HP Orang Tua</label>
                <input type="text" name="no_hp_orangtua" value="{{ old('no_hp_orangtua') }}" class="{{ $input }} mt-1">
                @error('no_hp_orangtua') <p class="{{ $err }}">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="{{ $label }}">Penghasilan Orang Tua</label>
                <input type="text" name="penghasilan_orangtua" value="{{ old('penghasilan_orangtua') }}" placeholder="cth: 3.000.000" class="{{ $input }} mt-1">
                @error('penghasilan_orangtua') <p class="{{ $err }}">{{ $message }}</p> @enderror
            </div>
        </div>
    </section>

    {{-- 3. PILIHAN JURUSAN --}}
    <section class="rounded-xl border border-slate-200 bg-white p-5 sm:p-6">
        <div class="mb-4 flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-50 text-brand-600"><i data-lucide="blocks" class="h-5 w-5"></i></span>
            <div>
                <h3 class="font-semibold text-slate-900">3. Pilihan Jurusan</h3>
                <p class="text-xs text-slate-500">Pilihan 2 tidak boleh sama dengan Pilihan 1</p>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <label class="{{ $label }}">Pilihan Jurusan 1 <span class="text-rose-500">*utama</span></label>
                <select name="pilihan_1" class="{{ $input }} mt-1">
                    <option value="">-- Pilih Jurusan Utama --</option>
                    @foreach ($majors as $m)
                        <option value="{{ $m->id }}" {{ old('pilihan_1') == $m->id ? 'selected' : '' }}>
                            {{ $m->kode_jurusan }} — {{ $m->nama_jurusan }} (Kuota {{ $m->kuota }})
                        </option>
                    @endforeach
                </select>
                @error('pilihan_1') <p class="{{ $err }}">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="{{ $label }}">Pilihan Jurusan 2 <span class="text-rose-500">*cadangan</span></label>
                <select name="pilihan_2" class="{{ $input }} mt-1">
                    <option value="">-- Pilih Jurusan Cadangan --</option>
                    @foreach ($majors as $m)
                        <option value="{{ $m->id }}" {{ old('pilihan_2') == $m->id ? 'selected' : '' }}>
                            {{ $m->kode_jurusan }} — {{ $m->nama_jurusan }} (Kuota {{ $m->kuota }})
                        </option>
                    @endforeach
                </select>
                @error('pilihan_2') <p class="{{ $err }}">{{ $message }}</p> @enderror
            </div>
        </div>
        <div class="mt-4 flex flex-wrap gap-2">
            @foreach ($majors as $m)
                <span class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-50 px-2.5 py-1 text-xs font-medium text-slate-600">
                    <span class="font-bold text-brand-700">{{ $m->kode_jurusan }}</span> {{ $m->nama_jurusan }}
                </span>
            @endforeach
        </div>
    </section>

    {{-- 4. UPLOAD BERKAS --}}
    <section class="rounded-xl border border-slate-200 bg-white p-5 sm:p-6">
        <div class="mb-4 flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-50 text-brand-600"><i data-lucide="folder-check" class="h-5 w-5"></i></span>
            <div>
                <h3 class="font-semibold text-slate-900">4. Upload Berkas</h3>
                <p class="text-xs text-slate-500">KK & Rapor wajib, Ijazah & Pasfoto menyusul bila ada</p>
            </div>
        </div>
        @php
            $fileBox = 'mt-1 flex items-center gap-3 rounded-lg border border-dashed border-slate-300 bg-slate-50 px-3 py-2.5 transition-colors hover:border-brand-500 hover:bg-brand-50/40';
        @endphp
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <label class="{{ $label }}">Kartu Keluarga (KK) <span class="text-rose-500">*wajib</span></label>
                <label class="{{ $fileBox }}">
                    <i data-lucide="file-up" class="h-5 w-5 shrink-0 text-slate-400"></i>
                    <span class="min-w-0 flex-1 truncate text-sm text-slate-500">PDF/JPG/PNG, maks 2MB</span>
                    <input type="file" name="berkas_kk" class="hidden">
                </label>
                @error('berkas_kk') <p class="{{ $err }}">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="{{ $label }}">Rapor <span class="text-rose-500">*wajib</span></label>
                <label class="{{ $fileBox }}">
                    <i data-lucide="file-up" class="h-5 w-5 shrink-0 text-slate-400"></i>
                    <span class="min-w-0 flex-1 truncate text-sm text-slate-500">PDF/JPG/PNG, maks 4MB</span>
                    <input type="file" name="berkas_rapor" class="hidden">
                </label>
                @error('berkas_rapor') <p class="{{ $err }}">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="{{ $label }}">Ijazah <span class="text-slate-400">(opsional)</span></label>
                <label class="{{ $fileBox }}">
                    <i data-lucide="file-up" class="h-5 w-5 shrink-0 text-slate-400"></i>
                    <span class="min-w-0 flex-1 truncate text-sm text-slate-500">PDF/JPG/PNG, maks 4MB</span>
                    <input type="file" name="berkas_ijazah" class="hidden">
                </label>
                @error('berkas_ijazah') <p class="{{ $err }}">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="{{ $label }}">Pasfoto <span class="text-slate-400">(opsional)</span></label>
                <label class="{{ $fileBox }}">
                    <i data-lucide="image-plus" class="h-5 w-5 shrink-0 text-slate-400"></i>
                    <span class="min-w-0 flex-1 truncate text-sm text-slate-500">JPG/PNG, maks 1MB</span>
                    <input type="file" name="berkas_pasfoto" class="hidden">
                </label>
                @error('berkas_pasfoto') <p class="{{ $err }}">{{ $message }}</p> @enderror
            </div>
        </div>
    </section>

    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-brand-600 px-3.5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-brand-700">
        <i data-lucide="send" class="h-4 w-4"></i>Kirim Pendaftaran
    </button>
    <p class="text-center text-xs text-slate-500">Dengan menekan Kirim, status Anda menjadi <span class="font-semibold text-amber-700">SUBMITTED</span> dan menunggu verifikasi Panitia.</p>
</form>
@endsection
