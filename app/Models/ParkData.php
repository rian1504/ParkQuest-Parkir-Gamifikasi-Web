<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParkData extends Model
{
    use HasFactory;

    protected $table = 'park_datas';

    protected $guarded = ['id'];

    public function park_area(): BelongsTo
    {
        return $this->belongsTo(ParkArea::class);
    }
}