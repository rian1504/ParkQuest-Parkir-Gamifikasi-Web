<?php

namespace App\Filament\Resources\SurveyResponseResource\Pages;

use Filament\Actions;
use Filament\Widgets\TableWidget;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\SurveyResponseResource;
use App\Models\Question;
use Filament\Widgets\Widget;

class ViewSurveyResponse extends ViewRecord
{
    protected static string $resource = SurveyResponseResource::class;

    protected static string $view = 'filament.widgets.survey-response';

    public function getTableData()
    {
        return $this->record->answer->map(function ($answer) {
            return [
                'question' => $answer->question->question ?? 'No question found',
                'answer' => $answer->answer,
            ];
        })->toArray();
    }
}
