<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RewardType extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function reward(): HasMany
    {
        return $this->hasMany(Reward::class);
    }
}