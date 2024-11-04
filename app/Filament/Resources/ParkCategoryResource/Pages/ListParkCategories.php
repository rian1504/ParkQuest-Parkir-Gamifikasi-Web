<?php

namespace App\Filament\Resources\ParkCategoryResource\Pages;

use App\Filament\Resources\ParkCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParkCategories extends ListRecords
{
    protected static string $resource = ParkCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
