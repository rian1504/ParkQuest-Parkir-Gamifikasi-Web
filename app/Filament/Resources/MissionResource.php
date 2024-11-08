<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Mission;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\MissionResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MissionResource\RelationManagers;
use App\Filament\Resources\MissionResource\Pages\EditMission;
use App\Filament\Resources\MissionResource\Pages\ListMissions;
use App\Filament\Resources\MissionResource\Pages\CreateMission;
use App\Models\MissionCategory;
use App\Models\Rank;
use App\Models\Reward;
use Filament\Tables\Actions\DeleteAction;

class MissionResource extends Resource
{
    protected static ?string $model = Mission::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = 'Misi';

    protected static ?string $slug = 'mission';

    protected static ?string $modelLabel = 'Misi';

    protected static ?string $navigationGroup = 'Data User';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        $missionCategory = MissionCategory::all();
        $reward = Reward::all();
        $rank = Rank::all();

        return $form
            ->schema([
                Select::make('mission_category_id')
                    ->label('Kategori Misi')
                    ->options($missionCategory->pluck('mission_category_name', 'id'))
                    ->native(false)
                    ->validationMessages([
                        'required' => 'Kategori Misi wajib diisi',
                    ])
                    ->required(),
                Select::make('reward_id')
                    ->label('Hadiah')
                    ->options($reward->pluck('reward_amount', 'id'))
                    ->native(false)
                    ->validationMessages([
                        'required' => 'Hadiah wajib diisi',
                    ])
                    ->required(),
                Select::make('rank_id')
                    ->label('Rank yang diperlukan')
                    ->options($rank->pluck('rank_name', 'id'))
                    ->native(false)
                    ->validationMessages([
                        'required' => 'Rank yang diperlukan wajib diisi',
                    ])
                    ->required(),
                TextInput::make('mission_name')
                    ->label('Nama Misi')
                    ->required()
                    ->validationMessages([
                        'required' => 'Nama Misi wajib diisi',
                    ])
                    ->maxLength(255),
                Textarea::make('mission_description')
                    ->label('Deskripsi Misi')
                    ->autosize()
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')
                    ->rowIndex(),
                TextColumn::make('mission_category.mission_category_name')
                    ->label('Kategori Misi'),
                TextColumn::make('reward.reward_type.reward_type_name')
                    ->label('Tipe Hadiah'),
                TextColumn::make('reward.reward_amount')
                    ->label('Jumlah Hadiah'),
                TextColumn::make('rank.rank_name')
                    ->label('Rank yang diperlukan'),
                TextColumn::make('mission_name')
                    ->label('Nama Misi')
                    ->description(fn(Mission $record): string => $record->mission_description)
                    ->searchable(),
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
            'index' => ListMissions::route('/'),
            'create' => CreateMission::route('/create'),
            'edit' => EditMission::route('/{record}/edit'),
        ];
    }
}
