<?php

namespace App\Filament\Resources;

use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\InternalRole;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\InternalRoleResource\RelationManagers;
use App\Filament\Resources\InternalRoleResource\Pages\EditInternalRole;
use App\Filament\Resources\InternalRoleResource\Pages\ListInternalRoles;
use App\Filament\Resources\InternalRoleResource\Pages\CreateInternalRole;
use Filament\Tables\Actions\DeleteAction;

class InternalRoleResource extends Resource
{
    protected static ?string $model = InternalRole::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    protected static ?string $navigationLabel = 'Internal Role';

    protected static ?string $slug = 'internal-role';

    protected static ?string $modelLabel = 'Internal Role';

    protected static ?string $navigationGroup = 'Data User';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('internal_role_name')
                    ->label('Nama Role')
                    ->required()
                    ->validationMessages([
                        'required' => 'Nama Role wajib diisi',
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
                TextColumn::make('internal_role_name')
                    ->label('Nama Role')
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
            'index' => ListInternalRoles::route('/'),
            'create' => CreateInternalRole::route('/create'),
            'edit' => EditInternalRole::route('/{record}/edit'),
        ];
    }
}
