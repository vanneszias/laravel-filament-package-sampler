<?php

namespace App\Filament\Resources\SurveyResource\Pages;

use App\Filament\Resources\SurveyResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Statikbe\Surveyhero\Services\SurveyImportService;

class ListSurveys extends ListRecords
{
    protected static string $resource = SurveyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('import_surveys')
                ->label('Import Surveys from API')
                ->icon('heroicon-o-arrow-down-on-square-stack')
                ->color('gray')
                ->visible(fn () => (bool) config('surveyhero.api_username') && (bool) config('surveyhero.api_password'))
                ->requiresConfirmation()
                ->modalHeading('Import Surveys from Surveyhero')
                ->modalDescription('This will fetch all surveys from the Surveyhero API and create or update them in the database.')
                ->action(function () {
                    try {
                        $result = app(SurveyImportService::class)->importSurveys(null);
                        $importedCount = count($result['imported']);
                        $notImportedCount = count($result['notImported']);

                        Notification::make()
                            ->title('Surveys imported successfully')
                            ->body("Imported: {$importedCount}" . ($notImportedCount ? ", skipped: {$notImportedCount}" : ''))
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
            Actions\CreateAction::make(),
        ];
    }
}
