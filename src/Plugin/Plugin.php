<?php

namespace Raakkan\OnlyLaravel\Plugin;

use Illuminate\Support\Str;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\File;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Plugin\Models\PluginModel;
use Raakkan\OnlyLaravel\Support\Concerns\HasLabel;
use Raakkan\OnlyLaravel\Plugin\Concerns\PluginActivation;
use Raakkan\OnlyLaravel\Plugin\Concerns\HasPluginMigration;

class Plugin
{
    use PluginActivation;
    use HasPluginMigration;
    use HasName;
    use HasLabel {
        getLabel as getPluginLabel;
    }
    
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
