<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\ParkData;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ParkCategory;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ParkDataResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ParkDataResource\RelationManagers;
use App\Filament\Resources\ParkDataResource\Pages\EditParkData;
use App\Filament\Resources\ParkDataResource\Pages\ListParkData;
use App\Filament\Resources\ParkDataResource\Pages\CreateParkData;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;

class ParkDataResource extends Resource
{
    protected static ?string $model = ParkData::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = 'Data Parkir';

    protected static ?string $slug = 'park-data';

    protected static ?string $modelLabel = 'Data Parkir';

    protected static ?string $navigationGroup = 'Data Parkir';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListParkData::route('/'),
            'create' => Pages\CreateParkData::route('/create'),
            'edit' => Pages\EditParkData::route('/{record}/edit'),
        ];
    }
}
