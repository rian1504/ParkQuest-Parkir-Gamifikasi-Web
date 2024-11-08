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
use App\Models\ParkArea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\TextColumn;

class ParkDataResource extends Resource
{
    protected static ?string $model = ParkData::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?string $navigationLabel = 'Data Parkir';

    protected static ?string $slug = 'park-data';

    protected static ?string $modelLabel = 'Data Parkir';

    protected static ?string $navigationGroup = 'Data Parkir';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        $parkArea = ParkArea::all();

        return $form
            ->schema([
                Select::make('park_area_id')
                    ->label('Area Parkir')
                    ->options($parkArea->pluck('park_name', 'id'))
                    ->native(false)
                    ->validationMessages([
                        'required' => 'Area Parkir wajib diisi',
                    ])
                    ->required(),
                TextInput::make('start_hour')
                    ->label('Jam Mulai')
                    ->required()
                    ->validationMessages([
                        'required' => 'Jam Mulai wajib diisi',
                        'minValue' => 'Jam Akhir tidak boleh kurang dari 1',
                        'maxValue' => 'Jam Akhir tidak boleh lebih dari 23',
                    ])
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(23),
                TextInput::make('end_hour')
                    ->label('Jam Akhir')
                    ->required()
                    ->validationMessages([
                        'required' => 'Jam Akhir wajib diisi',
                        'minValue' => 'Jam Akhir tidak boleh kurang dari 2',
                        'maxValue' => 'Jam Akhir tidak boleh lebih dari 24',
                    ])
                    ->numeric()
                    ->minValue(2)
                    ->maxValue(24),
                TextInput::make('available')
                    ->label('Ketersediaan Parkir')
                    ->required()
                    ->validationMessages([
                        'required' => 'Ketersediaan Parkir wajib diisi',
                        'minValue' => 'Ketersediaan Parkir tidak boleh minus',
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
                TextColumn::make('park_area.park_name')
                    ->label('Nama Area Parkir'),
                TextColumn::make('start_hour')
                    ->label('Jam Mulai')
                    ->suffix(':00'),
                TextColumn::make('end_hour')
                    ->label('Jam Akhir')
                    ->suffix(':00'),
                TextColumn::make('available')
                    ->label('Ketersediaan Parkir')
                    ->suffix(' unit'),
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
            'index' => ListParkData::route('/'),
            'create' => CreateParkData::route('/create'),
            'edit' => EditParkData::route('/{record}/edit'),
        ];
    }
}
