<?php

namespace Raakkan\OnlyLaravel\Plugin;

use Illuminate\Support\Facades\File;

class PluginManager
{
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

    public function getFilamentResources()
    {
        return collect($this->plugins)
            ->filter(function ($plugin) {
                return $this->pluginJsonManager->pluginIsActivated($plugin->getName());
            })
            ->map(function ($plugin) {
                return $plugin->getFilamentResources();
            })
            ->flatten()
            ->toArray();
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
}