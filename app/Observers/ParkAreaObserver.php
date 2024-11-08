<?php

namespace App\Observers;

use App\Models\ParkArea;
use Illuminate\Support\Facades\Storage;

class ParkAreaObserver
{
    public function saved(ParkArea $parkArea): void
    {
        if (!$parkArea->wasRecentlyCreated && $parkArea->isDirty('park_image')) {
            Storage::disk('public')->delete($parkArea->getOriginal('park_image'));
        }
    }

    public function deleted(ParkArea $parkArea): void
    {
        if (! is_null($parkArea->park_image)) {
            Storage::disk('public')->delete($parkArea->park_image);
        }
    }
}
