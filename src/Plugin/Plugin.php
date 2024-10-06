<?php

namespace Raakkan\OnlyLaravel\Plugin;

use Illuminate\Support\Str;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Raakkan\OnlyLaravel\Facades\PageManager;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Plugin\Models\PluginModel;
use Raakkan\OnlyLaravel\Support\Concerns\HasLabel;
use Raakkan\OnlyLaravel\Plugin\Concerns\HasPluginMenus;
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
    use HasPluginMenus;
    
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

    public function register(PluginManager $pluginManager)
    {
        $this->autoload();
        $pluginClass = $this->getPluginClass();
        
        if($pluginClass){
            $pluginClass->register($pluginManager);
            $pluginClass->onlyLaravel($pluginManager->getOnlyLaravel());
            $pluginClass->pages($pluginManager->getPageManager());
            $pluginClass->menus($pluginManager->getMenuManager());
            $pluginClass->templates($pluginManager->getTemplateManager());
        }
    }

    public function boot(PluginManager $pluginManager)
    {
        $viewPath = $this->path . '/resources/views';
        if (is_dir($viewPath)) {
            app('view')->addNamespace($this->name, $viewPath);
        }
        
        $this->registerLivewireComponents();
        $this->loadBladeComponents();
        $this->loadRoutes();
        $pluginClass = $this->getPluginClass();
        $pluginClass->boot($pluginManager);
    }

    protected function loadRoutes()
    {
        $webRoutesPath = $this->path . '/routes/web.php';
        $apiRoutesPath = $this->path . '/routes/api.php';

        if (file_exists($webRoutesPath)) {
            Route::middleware('web')->group(function () use ($webRoutesPath) {
                include $webRoutesPath;
            });
        }

        if (file_exists($apiRoutesPath)) {
            Route::middleware('api')->prefix('api')->group(function () use ($apiRoutesPath) {
                include $apiRoutesPath;
            });
        }
    }

    protected function loadBladeComponents()
    {
        $componentsPath = $this->path . '/resources/views/components';
        Blade::anonymousComponentNamespace($componentsPath, $this->name);
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
                        \Livewire\Livewire::component($this->name . '::' . $className::getComponentName(), $className);
                    }
                }
            }
        }
    }

    public function autoload(): void
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
