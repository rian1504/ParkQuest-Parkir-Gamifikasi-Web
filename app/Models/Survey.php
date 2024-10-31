<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Survey extends Model
{
    use HasFactory;

    public function reward(): BelongsTo
    {
        return $this->belongsTo(Reward::class);
    }

    public function question(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function survey_response(): HasMany
    {
        return $this->hasMany(SurveyResponse::class);
    }
}