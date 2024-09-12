<?php

namespace Raakkan\OnlyLaravel;

class OnlyLaravelManager
{
    protected $templates = [];
    protected $settingsPages = [];
    protected $routes = [];

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

    public function registerRoutes($routes)
    {
        $this->routes = array_merge($this->routes, $routes);
        return $this;
    }

    public function getRoutes()
    {
        $routes = array_merge($this->routes, $this->getPluginsRoutes());
        if (count($routes) > 0) {
            return $routes;
        }

        return null;
    }

    public function getPluginsRoutes()
    {
        return app('plugin-manager')->getPluginsRoutes();
    }
}
