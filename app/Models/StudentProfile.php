<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentProfile extends Model
{
    protected $fillable = [
        'registration_id', 'nama_lengkap', 'nisn', 'nik',
        'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
        'agama', 'no_hp', 'alamat_lengkap', 'sekolah_asal',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }
}