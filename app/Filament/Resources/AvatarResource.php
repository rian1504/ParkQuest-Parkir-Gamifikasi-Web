<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Avatar;
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
use App\Filament\Resources\AvatarResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AvatarResource\Pages\EditAvatar;
use App\Filament\Resources\AvatarResource\RelationManagers;
use App\Filament\Resources\AvatarResource\Pages\ListAvatars;
use App\Filament\Resources\AvatarResource\Pages\CreateAvatar;
use App\Models\Rarity;
use Filament\Tables\Actions\DeleteAction;

class AvatarResource extends Resource
{
    protected static ?string $model = Avatar::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationLabel = 'Avatar';

    protected static ?string $slug = 'avatar';

    protected static ?string $modelLabel = 'Avatar';

    protected static ?string $navigationGroup = 'Data Avatar';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        $rarity = Rarity::all();

        return $form
            ->schema([
                Select::make('rarity_id')
                    ->label('Nama Rarity')
                    ->options($rarity->pluck('rarity_name', 'id'))
                    ->native(false)
                    ->validationMessages([
                        'required' => 'Nama Rarity wajib diisi',
                    ])
                    ->required(),
                TextInput::make('avatar_name')
                    ->label('Nama Avatar')
                    ->required()
                    ->validationMessages([
                        'required' => 'Nama Avatar wajib diisi',
                    ])
                    ->maxLength(255),
                Textarea::make('avatar_description')
                    ->label('Deskripsi Avatar')
                    ->autosize()
                    ->columnSpanFull()
                    ->required(),
                FileUpload::make('avatar_image')
                    ->label('Gambar Avatar')
                    ->directory('image/avatar')
                    ->image()
                    ->columnSpanFull()
                    ->validationMessages([
                        'required' => 'Gambar Avatar wajib diisi',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')
                    ->rowIndex(),
                TextColumn::make('rarity.rarity_name')
                    ->label('Nama Rarity'),
                TextColumn::make('avatar_name')
                    ->label('Nama Avatar')
                    ->description(fn(Avatar $record): string => $record->avatar_description)
                    ->searchable(),
                ImageColumn::make('avatar_image')
                    ->label('Gambar Avatar')
                    ->circular()
                    ->size(80),
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
            'index' => ListAvatars::route('/'),
            'create' => CreateAvatar::route('/create'),
            'edit' => EditAvatar::route('/{record}/edit'),
        ];
    }
}
