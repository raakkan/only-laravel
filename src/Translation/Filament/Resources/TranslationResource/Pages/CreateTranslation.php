<?php

namespace Raakkan\OnlyLaravel\Translation\Filament\Resources\TranslationResource\Pages;

use Raakkan\OnlyLaravel\Translation\Filament\Resources\TranslationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTranslation extends CreateRecord
{
    protected static string $resource = TranslationResource::class;

    public function getTitle(): string
    {
        return 'Create Translation';
    }
}
