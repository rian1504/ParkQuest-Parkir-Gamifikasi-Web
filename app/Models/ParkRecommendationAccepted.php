<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParkRecommendationAccepted extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function park_recommendation(): BelongsTo
    {
        return $this->belongsTo(ParkRecommendation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reward(): BelongsTo
    {
        return $this->belongsTo(Reward::class);
    }
}