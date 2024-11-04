<?php

namespace App\Filament\Resources;

use App\Models\Rank;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RankResource\Pages\EditRank;
use App\Filament\Resources\RankResource\Pages\ListRanks;
use App\Filament\Resources\RankResource\Pages\CreateRank;
use App\Filament\Resources\RankResource\RelationManagers;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\DeleteAction;

class RankResource extends Resource
{
    protected static ?string $model = Rank::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationLabel = 'Rank';

    protected static ?string $slug = 'rank';

    protected static ?string $modelLabel = 'Rank';

    protected static ?string $navigationGroup = 'Data User';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('rank_name')
                    ->label('Nama Rank')
                    ->required()
                    ->validationMessages([
                        'required' => 'Nama Rank wajib diisi',
                    ])
                    ->maxLength(255),
                TextInput::make('exp_required')
                    ->label('EXP yang dibutuhkan')
                    ->required()
                    ->validationMessages([
                        'required' => 'EXP wajib diisi',
                        'minValue' => 'EXP tidak boleh minus',
                    ])
                    ->numeric()
                    ->minValue(0)
                    ->suffix(' EXP'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')
                    ->rowIndex(),
                TextColumn::make('rank_name')
                    ->label('Nama Rank')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('exp_required')
                    ->label('EXP yang dibutuhkan')
                    ->numeric()
                    ->sortable()
                    ->suffix(' EXP'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => ListRanks::route('/'),
            'create' => CreateRank::route('/create'),
            'edit' => EditRank::route('/{record}/edit'),
        ];
    }
}
