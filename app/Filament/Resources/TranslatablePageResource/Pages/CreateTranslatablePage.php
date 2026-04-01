<?php

namespace App\Filament\Resources\TranslatablePageResource\Pages;

use App\Filament\Resources\TranslatablePageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Pages\CreateRecord\Concerns\TranslatableWithMedia;

class CreateTranslatablePage extends CreateRecord
{
    use TranslatableWithMedia;

    protected static string $resource = TranslatablePageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            LocaleSwitcher::make(),
        ];
    }
}
