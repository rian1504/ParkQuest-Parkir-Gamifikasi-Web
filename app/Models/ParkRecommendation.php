<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ParkRecommendation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function park_area(): BelongsTo
    {
        return $this->belongsTo(ParkArea::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function park_recommendation_accepted(): HasMany
    {
        return $this->hasMany(ParkRecommendationAccepted::class);
    }
}