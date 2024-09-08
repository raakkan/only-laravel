<?php

namespace Raakkan\OnlyLaravel;

class OnlyLaravelManager
{
    protected $templates = [];
    protected $settingsPages = [];

    public function registerTemplates($templates)
    {
        $this->templates = array_merge($this->templates, $templates);
        return $this;
    }

    public function getTemplates()
    {
        return $this->templates;
    }

    public function registerSettingsPages($pages)
    {
        $this->settingsPages = array_merge($this->settingsPages, $pages);
        return $this;
    }

    public function getSettingsPages()
    {
        return $this->settingsPages;
    }

    public function loadSettingsPagesFromApp()
    {
        $settingsFolder = app_path('OnlyLaravel/Settings');
        
        if (file_exists($settingsFolder)) {
            $files = glob($settingsFolder . '/*.php');
            
            foreach ($files as $file) {
                $className = basename($file, '.php');
                $class = 'App\\OnlyLaravel\\Settings\\' . $className;
                
                if (class_exists($class)) {
                    $this->registerSettingsPages([$class]);
                }
            }
        }
        
        return $this;
    }
}
