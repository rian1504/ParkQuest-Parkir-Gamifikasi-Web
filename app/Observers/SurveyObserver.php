<?php

namespace App\Observers;

use App\Models\Survey;
use Illuminate\Support\Facades\Storage;

class SurveyObserver
{
    public function saved(Survey $survey): void
    {
        if (!$survey->wasRecentlyCreated && $survey->isDirty('survey_video')) {
            Storage::disk('public')->delete($survey->getOriginal('survey_video'));
        }
    }

    public function deleted(Survey $survey): void
    {
        if (! is_null($survey->survey_video)) {
            Storage::disk('public')->delete($survey->survey_video);
        }
    }
}