<?php

namespace App\Filament\Resources;

use Filament\Tables\Table;
use App\Models\SurveyResponse;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\SurveyResponseResource\Pages\ListSurveyResponses;
use App\Filament\Resources\SurveyResponseResource\Pages\ViewSurveyResponse;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ViewColumn;

class SurveyResponseResource extends Resource
{
    protected static ?string $model = SurveyResponse::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift-top';

    protected static ?string $navigationLabel = 'Survey Response';

    protected static ?string $slug = 'survey-response';

    protected static ?string $modelLabel = 'Survey Response';

    protected static ?string $navigationGroup = 'Data Survey';

    protected static ?int $navigationSort = 2;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('No')
                    ->rowIndex(),
                TextColumn::make('survey.survey_name')
                    ->label('Nama Survey')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Nama User'),
                TextColumn::make('answer.answer')
                    ->label('Nama User'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make()
                    ->color('info'),
            ])
            ->bulkActions([
                //
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
            'index' => ListSurveyResponses::route('/'),
            'view' => ViewSurveyResponse::route('/{record}'),
        ];
    }
}
