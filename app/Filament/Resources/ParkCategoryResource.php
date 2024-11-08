<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ParkCategory;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ParkCategoryResource\Pages;
use App\Filament\Resources\ParkCategoryResource\RelationManagers;
use App\Filament\Resources\ParkCategoryResource\Pages\EditParkCategory;
use App\Filament\Resources\ParkCategoryResource\Pages\CreateParkCategory;
use App\Filament\Resources\ParkCategoryResource\Pages\ListParkCategories;
use Filament\Tables\Actions\DeleteAction;

class ParkCategoryResource extends Resource
{
    protected static ?string $model = ParkCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = 'Kategori Parkir';

    protected static ?string $slug = 'park-category';

    protected static ?string $modelLabel = 'Kategori Parkir';

    protected static ?string $navigationGroup = 'Data Parkir';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('park_category_name')
                    ->label('Kategori Parkir')
                    ->required()
                    ->validationMessages([
                        'required' => 'Kategori Parkir wajib diisi',
                    ])
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')
                    ->rowIndex(),
                TextColumn::make('park_category_name')
                    ->label('Kategori Parkir')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListParkCategories::route('/'),
            'create' => CreateParkCategory::route('/create'),
            'edit' => EditParkCategory::route('/{record}/edit'),
        ];
    }
}
