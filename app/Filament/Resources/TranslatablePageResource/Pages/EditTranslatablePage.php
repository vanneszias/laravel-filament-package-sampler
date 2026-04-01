<?php

namespace App\Filament\Resources\TranslatablePageResource\Pages;

use App\Filament\Resources\TranslatablePageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use LaraZeus\SpatieTranslatable\Actions\LocaleSwitcher;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Pages\EditRecord\Concerns\TranslatableWithMedia;
use Statikbe\FilamentFlexibleContentBlocks\Filament\Resource\Pages\Actions\CopyContentBlocksToLocalesAction;

class EditTranslatablePage extends EditRecord
{
    use TranslatableWithMedia;

    protected static string $resource = TranslatablePageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            LocaleSwitcher::make(),
            CopyContentBlocksToLocalesAction::make(),
        ];
    }
}
