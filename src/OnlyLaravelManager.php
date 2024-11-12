<?php

namespace Raakkan\OnlyLaravel;

use Raakkan\OnlyLaravel\OnlyLaravel\Concerns\CollectsSettingPages;
use Raakkan\OnlyLaravel\OnlyLaravel\Concerns\HasInstall;

class OnlyLaravelManager
{
    use CollectsSettingPages;
    use HasInstall;

    protected $settingPages = [];

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
}
