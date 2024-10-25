<?php

namespace Raakkan\OnlyLaravel\Translation\Filament\Resources\LanguageResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Raakkan\OnlyLaravel\Translation\Filament\Resources\LanguageResource;

class ListLanguages extends ListRecords
{
    protected static string $resource = LanguageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
