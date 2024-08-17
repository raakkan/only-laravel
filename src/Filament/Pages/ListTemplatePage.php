<?php

namespace Raakkan\OnlyLaravel\Filament\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Raakkan\OnlyLaravel\Filament\Resources\TemplateResource;

class ListTemplatePage extends ListRecords
{
    protected static string $resource = TemplateResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }
}
