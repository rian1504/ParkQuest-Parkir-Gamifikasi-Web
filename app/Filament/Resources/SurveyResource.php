<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Survey;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\SurveyResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SurveyResource\Pages\EditSurvey;
use App\Filament\Resources\SurveyResource\RelationManagers;
use App\Filament\Resources\SurveyResource\Pages\ListSurveys;
use App\Filament\Resources\SurveyResource\Pages\CreateSurvey;
use App\Filament\Resources\SurveyResource\Pages\ViewSurvey;
use App\Models\Reward;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;

class SurveyResource extends Resource
{
    protected static ?string $model = Survey::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift-top';

    protected static ?string $navigationLabel = 'Survey';

    protected static ?string $slug = 'survey';

    protected static ?string $modelLabel = 'Survey';

    protected static ?string $navigationGroup = 'Data Survey';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        $reward = Reward::with('reward_type')->get();

        return $form
            ->schema([
                Select::make('reward_id')
                    ->label('Hadiah')
                    ->options(
                        $reward->mapWithKeys(function ($reward) {
                            return [
                                $reward->id => $reward->reward_type->reward_type_name . ' - ' . $reward->reward_amount,
                            ];
                        })
                    )
                    ->native(false)
                    ->validationMessages([
                        'required' => 'Hadiah wajib diisi',
                    ])
                    ->required(),
                TextInput::make('survey_name')
                    ->label('Nama Survey')
                    ->required()
                    ->validationMessages([
                        'required' => 'Nama Survey wajib diisi',
                    ])
                    ->maxLength(255),
                FileUpload::make('survey_video')
                    ->label('Video Survey')
                    ->directory('video/survey')
                    ->acceptedFileTypes(['video/mp4'])
                    ->maxSize(30000)
                    ->fetchFileInformation(false)
                    ->columnSpanFull()
                    ->validationMessages([
                        'required' => 'Video Survey wajib diisi',
                    ])
                    ->required()
                    ->fetchFileInformation(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')
                    ->rowIndex(),
                TextColumn::make('reward.reward_type.reward_type_name')
                    ->label('Kategori Hadiah'),
                TextColumn::make('reward.reward_amount')
                    ->label('Jumlah Hadiah'),
                TextColumn::make('survey_name')
                    ->label('Nama Survey')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make()
                    ->label('Lihat Video')
                    ->color('info'),
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
            'index' => ListSurveys::route('/'),
            'create' => CreateSurvey::route('/create'),
            'edit' => EditSurvey::route('/{record}/edit'),
            'view' => ViewSurvey::route('/{record}'),
        ];
    }
}