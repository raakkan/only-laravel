<?php

namespace Raakkan\OnlyLaravel\Filament\Pages\Page;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Raakkan\OnlyLaravel\Facades\PageManager;
use Raakkan\OnlyLaravel\Filament\Resources\PageResource;

class EditPage extends EditRecord
{
    use EditRecord\Concerns\Translatable;

    protected static string $resource = PageResource::class;

    protected function getActions(): array
    {
        $actions = [];
        if (PageManager::pageIsDeletable($this->record->name)) {
            $actions[] = Actions\DeleteAction::make();
        }

        return array_merge($actions, [
            Actions\LocaleSwitcher::make(),
        ]);
    }

    protected function afterSave(): void
    {
        app('only-laravel')->generateSitemap();
    }
}
