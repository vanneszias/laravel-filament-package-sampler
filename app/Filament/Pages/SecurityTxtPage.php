<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class SecurityTxtPage extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    protected string $view = 'filament.pages.security-txt-page';

    protected static ?string $navigationLabel = 'Security.txt';

    protected static ?string $title = 'Security.txt';

    public function getFileContent(): ?string
    {
        $path = config('security-txt.output_path');

        if (! $path || ! File::exists($path)) {
            return null;
        }

        return File::get($path);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('update')
                ->label('Update security.txt')
                ->icon('heroicon-o-arrow-path')
                ->action(function () {
                    $exitCode = Artisan::call('security-txt:update');

                    if ($exitCode === 0) {
                        Notification::make()
                            ->title('security.txt updated successfully')
                            ->success()
                            ->send();
                    } else {
                        Notification::make()
                            ->title('Update failed')
                            ->body('Check your SECURITY_TXT_TEMPLATE_URL configuration.')
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
