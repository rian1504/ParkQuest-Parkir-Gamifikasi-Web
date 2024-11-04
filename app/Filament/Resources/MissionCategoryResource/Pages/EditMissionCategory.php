<?php

namespace App\Filament\Resources\MissionCategoryResource\Pages;

use App\Filament\Resources\MissionCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMissionCategory extends EditRecord
{
    protected static string $resource = MissionCategoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
