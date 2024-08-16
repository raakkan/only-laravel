<?php

declare(strict_types=1);

namespace Raakkan\OnlyLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class TemplateManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'template-manager';
    }
}
