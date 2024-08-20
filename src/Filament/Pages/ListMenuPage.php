<?php

namespace Raakkan\OnlyLaravel\Filament\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Raakkan\OnlyLaravel\Filament\Resources\MenuResource;

class ListMenuPage extends ListRecords
{
    protected static string $resource = MenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
