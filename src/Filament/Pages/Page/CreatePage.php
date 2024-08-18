<?php

namespace Raakkan\OnlyLaravel\Filament\Pages\Page;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Raakkan\OnlyLaravel\Filament\Resources\PageResource;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;
}
