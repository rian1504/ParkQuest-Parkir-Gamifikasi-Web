<?php

namespace App\Filament\Resources\MissionCategoryResource\Pages;

use App\Filament\Resources\MissionCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMissionCategory extends CreateRecord
{
    protected static string $resource = MissionCategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
