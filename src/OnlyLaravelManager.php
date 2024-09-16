<?php

namespace Raakkan\OnlyLaravel;

class OnlyLaravelManager
{
    protected $filamentPages = [];
    protected $filamentResources = [];
    protected $filamentNavigationGroups = [];
    protected $routes = [];

    public function registerFilamentPages($pages)
    {
        $this->filamentPages = array_merge($this->filamentPages, $pages);
        return $this;
    }

    public function registerFilamentResources($resources)
    {
        $this->filamentResources = array_merge($this->filamentResources, $resources);
        return $this;
    }
    
    public function registerFilamentNavigationGroups($navigationGroups)
    {
        $this->filamentNavigationGroups = array_merge($this->filamentNavigationGroups, $navigationGroups);
        return $this;
    }

    public function getFilamentPages()
    {
        return $this->filamentPages;
    }

    public function getFilamentResources()
    {
        return $this->filamentResources;
    }

    public function getFilamentNavigationGroups()
    {
        return $this->filamentNavigationGroups;
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
                    $this->registerFilamentPages([$class]);
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
        if (count($this->routes) > 0) {
            return $this->routes;
        }

        return null;
    }
}
