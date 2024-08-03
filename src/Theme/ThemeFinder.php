<?php

declare(strict_types=1);

namespace Raakkan\OnlyLaravel\Theme;

use Illuminate\Support\Collection;
use Symfony\Component\Finder\Finder;
use Illuminate\Support\Facades\Config;
use Raakkan\OnlyLaravel\Support\Helpers\Json;

class ThemeFinder
{
    public static function find(): Collection
    {
        $path = base_path(Config::get('only-laravel::themes.directory', 'themes'));

        if (! file_exists($path)) {
            return collect();
        }

        $themePackages = collect(
            Finder::create()
                ->depth(2)
                ->files()
                ->followLinks()
                ->in($path)
                ->exclude(['node_modules', 'vendor'])
                ->name('composer.json')
        );

        $themes = collect();

        $themePackages->each(
            function ($themePackage) use ($themes): void {
                $info = Json::make($themePackage->getPathname(), app('files'));

                $theme = Theme::make($info->get('name'), dirname($themePackage->getPathname()));

                $theme->setName($info->get('name'))
                    ->setVersion($info->get('version', '0.1'))
                    ->setDescription($info->get('description', ''))
                    ->setParent($info->get('extra.theme.parent'))
                    ->setExtra($info->get('extra.theme', []))
                    ->setScreenshot($info->get('extra.theme.screenshot', ''));

                $themes->put($info->get('name'), $theme);
            }
        );

        return $themes;
    }
}
