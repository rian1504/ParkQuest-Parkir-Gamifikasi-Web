<?php

namespace App\Filament\Resources\RewardTypeResource\Pages;

use App\Filament\Resources\RewardTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRewardTypes extends ListRecords
{
    protected static string $resource = RewardTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
