<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Reward;
use Filament\Forms\Form;
use App\Models\RewardType;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\RewardResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RewardResource\Pages\EditReward;
use App\Filament\Resources\RewardResource\RelationManagers;
use App\Filament\Resources\RewardResource\Pages\ListRewards;
use App\Filament\Resources\RewardResource\Pages\CreateReward;
use Filament\Tables\Actions\DeleteAction;

class RewardResource extends Resource
{
    protected static ?string $model = Reward::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift-top';

    protected static ?string $navigationLabel = 'Hadiah';

    protected static ?string $slug = 'reward';

    protected static ?string $modelLabel = 'Hadiah';

    protected static ?string $navigationGroup = 'Data Misi';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        $rewardType = RewardType::all();

        return $form
            ->schema([
                Select::make('reward_type_id')
                    ->label('Tipe Hadiah')
                    ->options($rewardType->pluck('reward_type_name', 'id'))
                    ->native(false)
                    ->validationMessages([
                        'required' => 'Tipe Hadiah wajib diisi',
                    ])
                    ->required(),
                TextInput::make('reward_amount')
                    ->label('Jumlah Hadiah')
                    ->required()
                    ->validationMessages([
                        'required' => 'Jumlah Hadiah wajib diisi',
                        'minValue' => 'Jumlah Hadiah tidak boleh minus',
                    ])
                    ->numeric()
                    ->minValue(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')
                    ->rowIndex(),
                TextColumn::make('reward_type.reward_type_name')
                    ->label('Tipe Hadiah'),
                TextColumn::make('reward_amount')
                    ->label('Jumlah Hadiah'),
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
            'index' => ListRewards::route('/'),
            'create' => CreateReward::route('/create'),
            'edit' => EditReward::route('/{record}/edit'),
        ];
    }
}
