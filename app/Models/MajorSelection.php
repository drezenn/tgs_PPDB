<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MajorSelection extends Model
{
    protected $fillable = ['registration_id', 'major_id', 'pilihan_ke'];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }
}