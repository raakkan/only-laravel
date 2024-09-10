<?php
declare(strict_types=1);
namespace Raakkan\OnlyLaravel\Plugin\Facades;

use Illuminate\Support\Facades\Facade;

class PluginManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'plugin-manager';
    }
}