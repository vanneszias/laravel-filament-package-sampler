<?php

namespace App\Filament\Resources\SurveyResource\RelationManagers;

use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Statikbe\Surveyhero\Services\SurveyQuestionsAndAnswersImportService;

class SurveyQuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'surveyQuestions';

    protected static ?string $title = 'Survey Questions';

    public function form(Schema $form): Schema
    {
        return $form->schema([]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('surveyhero_question_id')
                    ->label('Question ID')
                    ->sortable(),
                TextColumn::make('label')
                    ->label('Question')
                    ->getStateUsing(fn ($record) => $record->getTranslation('label', app()->getLocale(), false)
                        ?? $record->getTranslations('label')[array_key_first($record->getTranslations('label') ?? [])] ?? '—')
                    ->wrap(),
                TextColumn::make('field')
                    ->label('Mapped Field')
                    ->badge()
                    ->color('gray'),
                TextColumn::make('surveyAnswers_count')
                    ->label('Answers')
                    ->counts('surveyAnswers')
                    ->sortable(),
            ])
            ->defaultSort('surveyhero_question_id')
            ->headerActions([
                \Filament\Actions\Action::make('import_questions')
                    ->label('Import from API')
                    ->icon('heroicon-o-arrow-down-on-square')
                    ->visible(fn () => (bool) config('surveyhero.api_username') && (bool) config('surveyhero.api_password'))
                    ->requiresConfirmation()
                    ->action(function () {
                        try {
                            app(SurveyQuestionsAndAnswersImportService::class)
                                ->importSurveyQuestionsAndAnswers($this->getOwnerRecord());

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
            ])
            ->actions([])
            ->bulkActions([]);
    }
}
