<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rarity extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function avatar(): HasMany
    {
        return $this->hasMany(Avatar::class);
    }
}