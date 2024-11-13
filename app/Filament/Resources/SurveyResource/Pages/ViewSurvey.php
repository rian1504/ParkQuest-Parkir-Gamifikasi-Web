<?php

namespace App\Filament\Resources\SurveyResource\Pages;

use App\Filament\Resources\SurveyResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSurvey extends ViewRecord
{
    protected static string $resource = SurveyResource::class;

    protected static string $view = 'filament.pages.view-survey';
}