<?php

namespace Raakkan\OnlyLaravel\Translation\Filament\Resources\TranslationResource\Pages;

use Raakkan\OnlyLaravel\Translation\Filament\Resources\TranslationResource;
use Filament\Resources\Pages\EditRecord;

class EditTranslation extends EditRecord
{
    protected static string $resource = TranslationResource::class;

    public function getTitle(): string
    {
        return 'Edit Translation';
    }
}
