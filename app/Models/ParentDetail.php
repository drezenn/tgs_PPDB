<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParentDetail extends Model
{
    protected $fillable = [
        'registration_id', 'nama_ayah', 'pekerjaan_ayah',
        'nama_ibu', 'pekerjaan_ibu', 'no_hp_orangtua',
        'penghasilan_orangtua',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }
}