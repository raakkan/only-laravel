<?php

declare(strict_types=1);

namespace Raakkan\OnlyLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class FontManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'font-manager';
    }
}
