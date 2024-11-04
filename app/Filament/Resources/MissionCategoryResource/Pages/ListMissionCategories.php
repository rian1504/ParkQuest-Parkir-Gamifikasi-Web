<?php

namespace App\Filament\Resources\MissionCategoryResource\Pages;

use App\Filament\Resources\MissionCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMissionCategories extends ListRecords
{
    protected static string $resource = MissionCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
