<?php

namespace Raakkan\OnlyLaravel\Filament\Pages\Page;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Raakkan\OnlyLaravel\Filament\Resources\PageResource;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}