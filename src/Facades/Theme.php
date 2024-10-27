<?php

namespace Raakkan\OnlyLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class Theme extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'theme-manager';
    }
}
