<?php

namespace Raakkan\ThemesManager\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

trait HasThemeClass
{
    protected $themeClass;

    protected function hasThemeClass(): bool
    {
        return isset($this->themeClass);
    }

    protected function registerThemeClass()
    {
        $themeClass = $this->getThemeClass();

        if ($themeClass) {
            require_once $themeClass;

            $theme = '\\' . Str::ucfirst($this->vendor) . '\\' . Str::ucfirst($this->name) . '\\Theme';
            
            if (class_exists($theme)) {
                $this->autoload();
                $this->themeClass = new $theme();
            }
        }
    }

    protected function getThemeClass(): string
    {
        $path = $this->getPath('src');

        if (File::isDirectory($path)) {
            $themeClass = $path . '/Theme.php';

            if (File::exists($themeClass)) {
                return $themeClass;
            }
        }

        return '';
    }

    protected function autoload(): void
    {
        $path = $this->getPath('src');

        if (File::isDirectory($path)) {
            $files = File::allFiles($path);
            
            foreach ($files as $file) {
                if (Str::endsWith($file->getFilename(), '.php')) {
                    require_once $file->getPathname();
                }
            }
        }
    }
}
