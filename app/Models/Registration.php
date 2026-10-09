<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Registration extends Model
{
    protected $fillable = ['nomor_pendaftaran', 'status', 'submitted_at'];

    protected function casts(): array
    {
        return ['submitted_at' => 'datetime'];
    }

    public function studentProfile(): HasOne
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function parentDetail(): HasOne
    {
        return $this->hasOne(ParentDetail::class);
    }

    public function majorSelections(): HasMany
    {
        return $this->hasMany(MajorSelection::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}