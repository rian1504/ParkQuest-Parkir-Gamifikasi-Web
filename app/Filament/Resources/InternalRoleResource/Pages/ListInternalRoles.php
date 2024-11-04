<?php

namespace App\Filament\Resources\InternalRoleResource\Pages;

use App\Filament\Resources\InternalRoleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInternalRoles extends ListRecords
{
    protected static string $resource = InternalRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
