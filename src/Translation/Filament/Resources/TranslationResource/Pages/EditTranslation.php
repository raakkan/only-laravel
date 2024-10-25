<?php

namespace Raakkan\OnlyLaravel\Translation\Filament\Resources\TranslationResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Raakkan\OnlyLaravel\Translation\Filament\Resources\TranslationResource;

class EditTranslation extends EditRecord
{
    protected static string $resource = TranslationResource::class;

    public function getTitle(): string
    {
        return 'Edit Translation';
    }
}
