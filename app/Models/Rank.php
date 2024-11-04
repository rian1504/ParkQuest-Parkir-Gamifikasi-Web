<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rank extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function mission(): HasMany
    {
        return $this->hasMany(Mission::class);
    }

    public function rank_up_date(): HasMany
    {
        return $this->hasMany(RankUpDate::class);
    }
}