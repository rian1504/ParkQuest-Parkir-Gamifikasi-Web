<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Rarity;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\RarityResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RarityResource\Pages\EditRarity;
use App\Filament\Resources\RarityResource\RelationManagers;
use App\Filament\Resources\RarityResource\Pages\CreateRarity;
use App\Filament\Resources\RarityResource\Pages\ListRarities;
use Filament\Tables\Actions\DeleteAction;

class RarityResource extends Resource
{
    protected static ?string $model = Rarity::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationLabel = 'Rarity';

    protected static ?string $slug = 'rarity';

    protected static ?string $modelLabel = 'Rarity';

    protected static ?string $navigationGroup = 'Data Avatar';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('rarity_name')
                    ->label('Nama Rarity')
                    ->required()
                    ->validationMessages([
                        'required' => 'Nama Rarity wajib diisi',
                    ])
                    ->maxLength(255),
                TextInput::make('price')
                    ->label('Harga')
                    ->required()
                    ->validationMessages([
                        'required' => 'Harga wajib diisi',
                        'minValue' => 'Harga tidak boleh minus',
                    ])
                    ->numeric()
                    ->minValue(0)
                    ->suffix(' Koin'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')
                    ->rowIndex(),
                TextColumn::make('rarity_name')
                    ->label('Nama Rarity')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Harga')
                    ->numeric()
                    ->sortable()
                    ->suffix(' Koin'),
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
            'index' => ListRarities::route('/'),
            'create' => CreateRarity::route('/create'),
            'edit' => EditRarity::route('/{record}/edit'),
        ];
    }
}
