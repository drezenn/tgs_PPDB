<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PendaftaranController extends Controller
{
    public function create(): View
    {
        $majors = Major::where('is_active', true)->orderBy('nama_jurusan')->get();

        return view('pendaftaran.create', compact('majors'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            // Data siswa
            'nama_lengkap'   => ['required', 'string', 'max:255'],
            'nisn'           => ['required', 'digits:10', 'unique:student_profiles,nisn'],
            'nik'            => ['required', 'digits:16', 'unique:student_profiles,nik'],
            'tempat_lahir'   => ['required', 'string', 'max:100'],
            'tanggal_lahir'  => ['required', 'date', 'before:today'],
            'jenis_kelamin'  => ['required', 'in:L,P'],
            'agama'          => ['required', 'string', 'max:30'],
            'no_hp'          => ['required', 'string', 'max:20'],
            'alamat_lengkap' => ['required', 'string'],
            'sekolah_asal'   => ['required', 'string', 'max:255'],
            // Data orang tua
            'nama_ayah'             => ['required', 'string', 'max:255'],
            'pekerjaan_ayah'        => ['required', 'string', 'max:100'],
            'nama_ibu'              => ['required', 'string', 'max:255'],
            'pekerjaan_ibu'         => ['required', 'string', 'max:100'],
            'no_hp_orangtua'        => ['required', 'string', 'max:20'],
            'penghasilan_orangtua'   => ['required', 'string', 'max:50'],
            // Pilihan jurusan
            'pilihan_1' => ['required', 'exists:majors,id'],
            'pilihan_2' => ['required', 'exists:majors,id', 'different:pilihan_1'],
            // Berkas (sesuai enum documents: ijazah, kk, pasfoto, rapor)
            'berkas_kk'      => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
            'berkas_rapor'   => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
            'berkas_ijazah'  => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:4096'],
            'berkas_pasfoto' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        $registration = DB::transaction(function () use ($data, $request) {
            $reg = Registration::create([
                'nomor_pendaftaran' => $this->nomorBaru(),
                'status' => 'submitted',
                'submitted_at' => now(),
            ]);

            $reg->studentProfile()->create(collect($data)->only([
                'nama_lengkap', 'nisn', 'nik', 'tempat_lahir', 'tanggal_lahir',
                'jenis_kelamin', 'agama', 'no_hp', 'alamat_lengkap', 'sekolah_asal',
            ])->toArray());

            $reg->parentDetail()->create(collect($data)->only([
                'nama_ayah', 'pekerjaan_ayah', 'nama_ibu',
                'pekerjaan_ibu', 'no_hp_orangtua', 'penghasilan_orangtua',
            ])->toArray());

            $reg->majorSelections()->createMany([
                ['major_id' => $data['pilihan_1'], 'pilihan_ke' => 1],
                ['major_id' => $data['pilihan_2'], 'pilihan_ke' => 2],
            ]);

            foreach (['kk' => 'berkas_kk', 'rapor' => 'berkas_rapor', 'ijazah' => 'berkas_ijazah', 'pasfoto' => 'berkas_pasfoto'] as $jenis => $input) {
                if ($request->hasFile($input)) {
                    $reg->documents()->create([
                        'jenis_dokumen' => $jenis,
                        'file_path' => $request->file($input)->store('berkas', 'public'),
                        'status_verifikasi' => 'pending',
                    ]);
                }
            }

            return $reg;
        });

        return redirect()
            ->route('pendaftaran.sukses', $registration->nomor_pendaftaran)
            ->with('success', 'Pendaftaran berhasil! Nomor pendaftaran: ' . $registration->nomor_pendaftaran);
    }

    public function sukses(Registration $registration): View
    {
        $registration->load(['studentProfile', 'majorSelections.major']);

        return view('pendaftaran.sukses', compact('registration'));
    }

    private function nomorBaru(): string
    {
        $tahun = date('Y');
        $terakhir = Registration::where('nomor_pendaftaran', 'like', "PPDB-{$tahun}-%")
            ->orderBy('id', 'desc')->value('nomor_pendaftaran');
        $nomor = $terakhir ? ((int) substr($terakhir, -5)) + 1 : 1;

        return sprintf("PPDB-{$tahun}-%05d", $nomor);
    }
}
