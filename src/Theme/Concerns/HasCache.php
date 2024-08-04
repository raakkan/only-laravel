<?php

declare(strict_types=1);

namespace Raakkan\OnlyLaravel\Theme\Concerns;

use Raakkan\OnlyLaravel\Theme\ThemeFinder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait HasCache
{
    /**
     * Clear the themes cache if it is enabled.
     */
    public function clearCache(): bool
    {
        if (Config::get('only-laravel::themes.cache.enabled', false) === true) {
            return Cache::forget(Config::get('only-laravel::themes.cache.key', 'only-laravel::themes'));
        }

        return true;
    }

    /**
     * Get cached themes.
     */
    protected function getCache(): Collection
    {
        return Cache::remember(Config::get('only-laravel::themes.cache.key', 'only-laravel::themes'), Config::get('only-laravel::themes.cache.lifetime', 86400), function () {
            return ThemeFinder::find();
        });
    }
}
