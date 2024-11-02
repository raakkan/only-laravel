<?php

namespace Raakkan\OnlyLaravel;

use Raakkan\OnlyLaravel\OnlyLaravel\Concerns\CollectsSettingPages;
use Raakkan\OnlyLaravel\OnlyLaravel\Concerns\HasInstall;
use Raakkan\OnlyLaravel\Support\SitemapGenerator;

class OnlyLaravelManager
{
    use CollectsSettingPages;
    use HasInstall;

    protected $sitemapGenerator;
    protected $settingPages = [];

    public function __construct()
    {
        $this->sitemapGenerator = new SitemapGenerator;
    }

    public function loadSettingsPagesFromApp()
    {
        $settingsFolder = app_path('OnlyLaravel/Settings');

        if (file_exists($settingsFolder)) {
            $files = glob($settingsFolder.'/*.php');

            foreach ($files as $file) {
                $className = basename($file, '.php');
                $class = 'App\\OnlyLaravel\\Settings\\'.$className;

                if (class_exists($class)) {
                    $this->settingPages[] = $class;
                }
            }
        }

        return $this;
    }

    public function generateSitemap()
    {
        return $this->sitemapGenerator->generate();
    }
}
