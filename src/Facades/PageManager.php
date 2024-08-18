<?php

declare(strict_types=1);

namespace Raakkan\OnlyLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class PageManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'page-manager';
    }
}
