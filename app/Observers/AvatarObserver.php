<?php

namespace App\Observers;

use App\Models\Avatar;
use Illuminate\Support\Facades\Storage;

class AvatarObserver
{
    public function saved(Avatar $avatar): void
    {
        if (!$avatar->wasRecentlyCreated && $avatar->isDirty('avatar_image')) {
            Storage::disk('public')->delete($avatar->getOriginal('avatar_image'));
        }
    }

    public function deleted(Avatar $avatar): void
    {
        if (! is_null($avatar->avatar_image)) {
            Storage::disk('public')->delete($avatar->avatar_image);
        }
    }
}
