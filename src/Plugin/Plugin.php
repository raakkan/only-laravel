<?php

namespace Raakkan\OnlyLaravel\Plugin;

use Illuminate\Support\Str;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\File;
use Raakkan\OnlyLaravel\Facades\PageManager;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Plugin\Models\PluginModel;
use Raakkan\OnlyLaravel\Support\Concerns\HasLabel;
use Raakkan\OnlyLaravel\Plugin\Concerns\HasPluginPages;
use Raakkan\OnlyLaravel\Plugin\Concerns\HasPluginBlocks;
use Raakkan\OnlyLaravel\Plugin\Concerns\PluginActivation;
use Raakkan\OnlyLaravel\Plugin\Concerns\HasPluginMigration;
use Raakkan\OnlyLaravel\Plugin\Concerns\HasPluginTemplates;

class Plugin
{
    use PluginActivation;
    use HasPluginMigration;
    use HasName;
    use HasLabel {
        getLabel as getPluginLabel;
    }
    use HasPluginPages;
    use HasPluginTemplates;
    
    protected $description;
    protected $version;
    protected $path;
    protected $namespace;

    public function __construct($name, $namespace, $label, $description, $version, $path)
    {
        $this->name = $name;
        $this->label = $label;
        $this->description = $description;
        $this->version = $version;
        $this->path = $path;
        $this->namespace = $namespace;
    }

    public function getLabel()
    {
        return $this->label ?? $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getNamespace()
    {
        return $this->namespace;
    }

    public function register()
    {
        $this->autoload();
        
        $viewPath = $this->path . '/resources/views';
        if (is_dir($viewPath)) {
            app('view')->addNamespace($this->name, $viewPath);
        }

        $this->registerLivewireComponents();
    }

    public function registerLivewireComponents()
    {
        $livewirePath = $this->path . '/src/Livewire';
        if (is_dir($livewirePath)) {
            $namespace = $this->namespace . '\\Livewire';
            foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($livewirePath)) as $file) {
                if ($file->isFile() && $file->getExtension() === 'php') {
                    $className = $namespace . '\\' . str_replace('/', '\\', substr($file->getPathname(), strlen($livewirePath) + 1, -4));
                    if (is_subclass_of($className, \Livewire\Component::class)) {
                        $componentName = (new \ReflectionClass($className))->getShortName();
                        \Livewire\Livewire::component($this->name . '::' . Str::kebab($componentName), $className);
                    }
                }
            }
        }
    }

    protected function autoload(): void
    {
        $path = $this->path . '/src';

        if (File::isDirectory($path)) {
            $files = File::allFiles($path);
            
            foreach ($files as $file) {
                if (Str::endsWith($file->getFilename(), '.php')) {
                    include $file->getPathname();
                }
            }
        }
    }

    public function getFilamentResources()
    {
        $pluginClass = $this->getPluginClass();

        return $pluginClass->filamentResources();
    }

    public function getFilamentPages()
    {
        $pluginClass = $this->getPluginClass();

        return $pluginClass->filamentPages();
    }

    public function getFilamentNavigationGroups()
    {
        $pluginClass = $this->getPluginClass();

        return $pluginClass->filamentNavigationGroups();
    }

    public function getRoutes()
    {
        $pluginClass = $this->getPluginClass();

        return $pluginClass->getRoutes();
    }

    public function getPageTypes()
    {
        $pluginClass = $this->getPluginClass();

        return $pluginClass->getPageTypes();
    }

    public function getPageTypeExternalPages()
    {
        $pluginClass = $this->getPluginClass();
        
        return $pluginClass->getPageTypeExternalPages();
    }

    protected function getPluginClass()
    {
        $pluginFile  = $this->path . '/src/Plugin.php';

        if (!File::exists($pluginFile)) {
            return;
        }
        
        $pluginClass = $this->namespace . '\Plugin';

        return new $pluginClass();
    }
}
