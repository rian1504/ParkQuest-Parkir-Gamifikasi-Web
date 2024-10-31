<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ParkCategory extends Model
{
    use HasFactory;

    public function park_area(): HasMany
    {
        return $this->hasMany(ParkArea::class);
    }
}