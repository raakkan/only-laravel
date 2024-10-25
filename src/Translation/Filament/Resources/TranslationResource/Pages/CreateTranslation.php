<?php

namespace Raakkan\OnlyLaravel\Translation\Filament\Resources\TranslationResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Raakkan\OnlyLaravel\Translation\Filament\Resources\TranslationResource;

class CreateTranslation extends CreateRecord
{
    protected static string $resource = TranslationResource::class;

    public function getTitle(): string
    {
        return 'Create Translation';
    }
}
