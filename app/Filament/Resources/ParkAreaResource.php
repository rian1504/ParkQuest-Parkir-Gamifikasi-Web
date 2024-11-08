<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\ParkArea;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\ParkAreaResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ParkAreaResource\RelationManagers;
use App\Filament\Resources\ParkAreaResource\Pages\EditParkArea;
use App\Filament\Resources\ParkAreaResource\Pages\ListParkAreas;
use App\Filament\Resources\ParkAreaResource\Pages\CreateParkArea;
use App\Models\ParkCategory;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Support\Facades\Storage;

class ParkAreaResource extends Resource
{
    protected static ?string $model = ParkArea::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = 'Area Parkir';

    protected static ?string $slug = 'park-area';

    protected static ?string $modelLabel = 'Area Parkir';

    protected static ?string $navigationGroup = 'Data Parkir';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        $parkCategory = ParkCategory::all();

        return $form
            ->schema([
                Select::make('park_category_id')
                    ->label('Kategori Parkir')
                    ->options($parkCategory->pluck('park_category_name', 'id'))
                    ->native(false)
                    ->validationMessages([
                        'required' => 'Kategori Parkir wajib diisi',
                    ])
                    ->required(),
                TextInput::make('park_name')
                    ->label('Nama Parkir')
                    ->required()
                    ->validationMessages([
                        'required' => 'Nama Parkir wajib diisi',
                    ])
                    ->maxLength(255),
                FileUpload::make('park_image')
                    ->label('Gambar Parkir')
                    ->directory('image/park_area')
                    ->image()
                    ->columnSpanFull()
                    ->validationMessages([
                        'required' => 'Gambar Parkir wajib diisi',
                    ])
                    ->required(),
                Textarea::make('park_information')
                    ->label('Informasi Parkir')
                    ->autosize()
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('park_capacity')
                    ->label('Kapasitas Parkir')
                    ->required()
                    ->validationMessages([
                        'required' => 'Kapasitas Parkir wajib diisi',
                        'minValue' => 'Kapasitas Parkir tidak boleh minus',
                    ])
                    ->numeric()
                    ->minValue(0),
                TextInput::make('park_coordinate')
                    ->label('Titik Koordinat')
                    ->required()
                    ->validationMessages([
                        'required' => 'Titik Koordinat wajib diisi',
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
                TextColumn::make('park_category.park_category_name')
                    ->label('Kategori Parkir'),
                TextColumn::make('park_name')
                    ->label('Nama Parkir')
                    ->searchable(),
                ImageColumn::make('park_image')
                    ->label('Gambar Parkir')
                    ->square()
                    ->size(80),
                TextColumn::make('park_capacity')
                    ->label('Kapasitas Parkir')
                    ->suffix(' unit'),
                TextColumn::make('park_coordinate')
                    ->label('Koordinat Parkir'),
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
            'index' => ListParkAreas::route('/'),
            'create' => CreateParkArea::route('/create'),
            'edit' => EditParkArea::route('/{record}/edit'),
        ];
    }
}
