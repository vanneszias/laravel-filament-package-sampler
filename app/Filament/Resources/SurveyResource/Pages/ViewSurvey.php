<?php

namespace App\Filament\Resources\SurveyResource\Pages;

use App\Filament\Resources\SurveyResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Statikbe\Surveyhero\Services\SurveyQuestionsAndAnswersImportService;
use Statikbe\Surveyhero\Services\SurveyResponseImportService;

class ViewSurvey extends ViewRecord
{
    protected static string $resource = SurveyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('import_questions')
                ->label('Import Questions & Answers')
                ->icon('heroicon-o-question-mark-circle')
                ->color('gray')
                ->visible(fn () => (bool) config('surveyhero.api_username') && (bool) config('surveyhero.api_password'))
                ->requiresConfirmation()
                ->modalHeading('Import Questions & Answers')
                ->modalDescription('This will fetch all questions and answers for this survey from the Surveyhero API.')
                ->action(function () {
                    try {
                        app(SurveyQuestionsAndAnswersImportService::class)
                            ->importSurveyQuestionsAndAnswers($this->record);

                        Notification::make()
                            ->title('Questions & answers imported')
                            ->success()
                            ->send();
                    } catch (\Throwable $e) {
                        Notification::make()
                            ->title('Import failed')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
            Actions\Action::make('import_responses')
                ->label('Import Responses')
                ->icon('heroicon-o-inbox-arrow-down')
                ->color('gray')
                ->visible(fn () => (bool) config('surveyhero.api_username') && (bool) config('surveyhero.api_password'))
                ->requiresConfirmation()
                ->modalHeading('Import Survey Responses')
                ->modalDescription('This will fetch all responses for this survey from the Surveyhero API.')
                ->action(function () {
                    try {
                        $info = app(SurveyResponseImportService::class)
                            ->importSurveyResponses($this->record);

                        $total = $info->getTotalResponsesImported();
                        $body = "Imported {$total} " . ($total === 1 ? 'response' : 'responses') . '.';

                        if ($info->hasUnimportedQuestions()) {
                            $body .= ' Some questions could not be imported.';
                        }

                        Notification::make()
                            ->title('Responses imported')
                            ->body($body)
                            ->success()
                            ->send();
                    } catch (\Throwable $e) {
                        Notification::make()
                            ->title('Import failed')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
            Actions\EditAction::make(),
        ];
    }
}
