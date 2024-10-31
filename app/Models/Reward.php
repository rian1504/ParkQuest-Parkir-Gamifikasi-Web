<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reward extends Model
{
    use HasFactory;

    public function reward_type(): BelongsTo
    {
        return $this->belongsTo(RewardType::class);
    }

    public function mission(): HasMany
    {
        return $this->hasMany(Mission::class);
    }

    public function park_recommendation_accepted(): HasMany
    {
        return $this->hasMany(ParkRecommendationAccepted::class);
    }

    public function survey(): HasMany
    {
        return $this->hasMany(Survey::class);
    }

    public function referral_usage(): HasMany
    {
        return $this->hasMany(ReferralUsage::class);
    }
}