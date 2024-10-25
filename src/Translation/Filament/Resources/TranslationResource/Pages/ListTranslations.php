<?php

namespace Raakkan\OnlyLaravel\Translation\Filament\Resources\TranslationResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Raakkan\OnlyLaravel\Translation\Filament\Resources\TranslationResource;

class ListTranslations extends ListRecords
{
    protected static string $resource = TranslationResource::class;

    public function getTitle(): string
    {
        return 'Translations';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
