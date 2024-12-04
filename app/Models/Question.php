<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Question extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function survey(): BelongsTo
    {
        return $this->belongsTo(Survey::class);
    }

    public function answer(): HasOne
    {
        return $this->hasOne(Answer::class);
    }
}
