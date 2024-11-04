<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\RewardType;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RewardTypeResource\Pages;
use App\Filament\Resources\RewardTypeResource\RelationManagers;
use App\Filament\Resources\RewardTypeResource\Pages\EditRewardType;
use App\Filament\Resources\RewardTypeResource\Pages\ListRewardTypes;
use App\Filament\Resources\RewardTypeResource\Pages\CreateRewardType;
use Filament\Tables\Actions\DeleteAction;

class RewardTypeResource extends Resource
{
    protected static ?string $model = RewardType::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    protected static ?string $navigationLabel = 'Tipe Hadiah';

    protected static ?string $slug = 'reward-type';

    protected static ?string $modelLabel = 'Tipe Hadiah';

    protected static ?string $navigationGroup = 'Data Misi';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('reward_type_name')
                    ->label('Tipe Hadiah')
                    ->required()
                    ->validationMessages([
                        'required' => 'Tipe Hadiah wajib diisi',
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
                TextColumn::make('reward_type_name')
                    ->label('Tipe Hadiah')
                    ->searchable()
                    ->sortable(),
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
            'index' => ListRewardTypes::route('/'),
            'create' => CreateRewardType::route('/create'),
            'edit' => EditRewardType::route('/{record}/edit'),
        ];
    }
}
