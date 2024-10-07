<?php

namespace Raakkan\OnlyLaravel\Translation\Filament\Resources\TranslationResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Raakkan\OnlyLaravel\Translation\Filament\Resources\TranslationResource;
use Filament\Actions;

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
