<?php

namespace Raakkan\OnlyLaravel\Filament\Pages\Page;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Raakkan\OnlyLaravel\Filament\Resources\PageResource;

class ListPage extends ListRecords
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
