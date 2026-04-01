<?php

namespace App\Filament\Actions;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Statikbe\PuppeteerPdfConverter\Exceptions\PdfApiException;
use Statikbe\PuppeteerPdfConverter\Facades\PuppeteerPdfConverter;

class DownloadPdfAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'download_pdf';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Download PDF')
            ->icon('heroicon-o-arrow-down-tray')
            ->color('gray')
            ->action(function ($record) {
                if (! config('puppeteer-pdf-converter.pdf_conversion_api')) {
                    Notification::make()
                        ->title('PDF converter not configured')
                        ->body('Set PDF_CONVERSION_API in your .env file to enable PDF generation.')
                        ->warning()
                        ->send();

                    return;
                }

                try {
                    $pdfUrl = PuppeteerPdfConverter::convertRoute(
                        'page_index',
                        ['page' => $record],
                        $record->slug.'.pdf'
                    );

                    $this->redirect($pdfUrl);
                } catch (PdfApiException $e) {
                    Notification::make()
                        ->title('PDF generation failed')
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }
}
