<?php

declare(strict_types=1);

namespace Raakkan\OnlyLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class MenuManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'menu-manager';
    }
}
