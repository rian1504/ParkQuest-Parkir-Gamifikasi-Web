<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ParkArea extends Model
{
    use HasFactory;

    public function park_category(): BelongsTo
    {
        return $this->belongsTo(ParkCategory::class);
    }

    public function park_data(): HasMany
    {
        return $this->hasMany(ParkData::class);
    }
}