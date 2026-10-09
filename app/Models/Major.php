<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $fillable = ['kode_jurusan', 'nama_jurusan', 'kuota', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }
}