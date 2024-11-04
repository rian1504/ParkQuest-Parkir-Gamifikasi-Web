<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MissionCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function mission(): HasMany
    {
        return $this->hasMany(Mission::class);
    }
}