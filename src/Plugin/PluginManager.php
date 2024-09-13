<?php

namespace Raakkan\OnlyLaravel\Plugin;

use Illuminate\Support\Facades\File;
use Raakkan\OnlyLaravel\Plugin\Concerns\HasFilamentResources;

class PluginManager
{
    use HasFilamentResources;
    protected $plugins = [];
    protected $pluginJsonManager;

    public function __construct()
    {
        $plugins = $this->loadPlugins();
        $this->pluginJsonManager = new PluginJsonManager($plugins);
        $this->plugins = $plugins;
    }

    public function loadPlugins()
    {
        $plugins = [];

        if (File::isDirectory(base_path('plugins'))) {
            $directories = File::directories(base_path('plugins'));

            foreach ($directories as $directory) {
                $pluginName = basename($directory);
                $composerFile = $directory . '/plugin.json';

                if (File::exists($composerFile)) {
                    $composerData = json_decode(File::get($composerFile), true);
                    $plugin = new Plugin(
                        $composerData['name'] ?? $pluginName,
                        $composerData['namespace'] ?? '',
                        $composerData['label'] ?? $pluginName,
                        $composerData['description'] ?? '',
                        $composerData['version'] ?? '',
                        $directory
                    );
                    $plugins[$pluginName] = $plugin;
                }
            }
        }

        return $plugins;
    }

    public function registerActivatedPlugins()
    {
        $activatedPlugins = $this->pluginJsonManager->getActivatedPlugins();
        foreach ($activatedPlugins as $name => $activatedPlugin) {
            $plugin = $this->getPlugin($name);
            $plugin->register();
        }
        return $this;
    }

    public function activatePlugin(string $name)
    {
        $this->pluginJsonManager->activatePlugin($name);
        return $this;
    }

    public function deactivatePlugin(string $name)
    {
        $this->pluginJsonManager->deactivatePlugin($name);
        return $this;
    }

    public function pluginIsActivated(string $name)
    {
        return $this->pluginJsonManager->pluginIsActivated($name);
    }

    public function getPlugin(string $name)
    {
        return $this->plugins[$name];
    }

    public function getPluginsRoutes()
    {
        return collect($this->plugins)
            ->filter(function ($plugin) {
                return $this->pluginJsonManager->pluginIsActivated($plugin->getName());
            })
            ->map(function ($plugin) {
                return $plugin->getRoutes();
            })
            ->flatten()
            ->toArray();
    }

    public function getPageTypes()
    {
        return collect($this->plugins)
            ->filter(function ($plugin) {
                return $this->pluginJsonManager->pluginIsActivated($plugin->getName());
            })
            ->map(function ($plugin) {
                return $plugin->getPageTypes();
            })
            ->flatten()
            ->toArray();
    }

    public function getPageTypeExternalPages($pageType = null)
    {
        $pageTypeExternalPages = collect($this->plugins)
            ->filter(function ($plugin) {
                return $this->pluginJsonManager->pluginIsActivated($plugin->getName());
            })
            ->map(function ($plugin) {
                return $plugin->getPageTypeExternalPages();
            })
            ->flatten()
            ->toArray();

        if ($pageType) {
            return collect($pageTypeExternalPages)->filter(function ($pageTypeExternalPage) use ($pageType) {
                return $pageTypeExternalPage->getParentPageType() == $pageType;
            })->toArray();
        }

        return $pageTypeExternalPages;
    }

    public function getPages()
    {
        return collect($this->plugins)
            ->filter(function ($plugin) {
                return $this->pluginJsonManager->pluginIsActivated($plugin->getName());
            })
            ->map(function ($plugin) {
                return $plugin->getPages();
            })
            ->flatten()
            ->toArray();
    }
}
