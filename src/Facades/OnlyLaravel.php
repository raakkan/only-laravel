<?php

declare(strict_types=1);

namespace Raakkan\OnlyLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class OnlyLaravel extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'only-laravel';
    }
}
