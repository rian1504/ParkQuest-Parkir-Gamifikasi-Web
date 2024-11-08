<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\MissionCategory;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MissionCategoryResource\Pages;
use App\Filament\Resources\MissionCategoryResource\RelationManagers;
use App\Filament\Resources\MissionCategoryResource\Pages\EditMissionCategory;
use App\Filament\Resources\MissionCategoryResource\Pages\CreateMissionCategory;
use App\Filament\Resources\MissionCategoryResource\Pages\ListMissionCategories;
use Filament\Tables\Actions\DeleteAction;

class MissionCategoryResource extends Resource
{
    protected static ?string $model = MissionCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';

    protected static ?string $navigationLabel = 'Kategori Misi';

    protected static ?string $slug = 'mission-category';

    protected static ?string $modelLabel = 'Kategori Misi';

    protected static ?string $navigationGroup = 'Data Misi';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('mission_category_name')
                    ->label('Kategori Misi')
                    ->required()
                    ->validationMessages([
                        'required' => 'Kategori Misi wajib diisi',
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
                TextColumn::make('mission_category_name')
                    ->label('Kategori Misi')
                    ->searchable()
                    ->sortable(),
            ])->defaultSort('id', 'desc')
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
            'index' => ListMissionCategories::route('/'),
            'create' => CreateMissionCategory::route('/create'),
            'edit' => EditMissionCategory::route('/{record}/edit'),
        ];
    }
}
