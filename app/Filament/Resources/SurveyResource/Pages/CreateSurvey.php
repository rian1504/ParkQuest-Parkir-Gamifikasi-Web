<?php

namespace App\Filament\Resources\SurveyResource\Pages;

use App\Filament\Resources\SurveyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateSurvey extends CreateRecord
{
    protected static string $resource = SurveyResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}