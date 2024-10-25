<?php

namespace Raakkan\OnlyLaravel\Plugin;

use Illuminate\Support\Facades\File;

class PluginJsonManager
{
    protected $plugins;

    public function __construct($plugins)
    {
        if ($this->checkOrCreatePluginsJson($plugins)) {
            $this->plugins = json_decode($this->getPluginsJson(), true);
        }
    }

    public function getActivatedPlugins()
    {
        return collect($this->plugins)->filter(function ($plugin) {
            return $plugin['activated'];
        })->toArray();
    }

    public function pluginExists($pluginName)
    {
        return isset($this->plugins[$pluginName]);
    }

    public function pluginIsActivated($pluginName)
    {
        if (! $this->pluginExists($pluginName)) {
            return false;
        }

        return $this->plugins[$pluginName]['activated'];
    }

    public function activatePlugin($pluginName)
    {
        if (! $this->pluginExists($pluginName)) {
            return false;
        }

        $this->plugins[$pluginName]['activated'] = true;
        $this->updatePluginsJson($this->plugins);
    }

    public function deactivatePlugin($pluginName)
    {
        if (! $this->pluginExists($pluginName)) {
            return false;
        }

        $this->plugins[$pluginName]['activated'] = false;
        $this->updatePluginsJson($this->plugins);
    }

    public function getPluginsJson()
    {
        return File::get(storage_path('onlylaravel/plugins.json'));
    }

    public function savePluginsJson(array $plugins)
    {
        File::put(
            storage_path('onlylaravel/plugins.json'),
            json_encode(collect($plugins)->mapWithKeys(function ($plugin) {
                return [$plugin->getName() => [
                    'version' => $plugin->getVersion(),
                    'activated' => $plugin->isActivated(),
                ]];
            })->toArray())
        );
    }

    public function updatePluginsJson(array $plugins)
    {
        File::put(storage_path('onlylaravel/plugins.json'), json_encode($plugins));
    }

    public function checkOrCreatePluginsJson(array $plugins = []): bool
    {
        $jsonPath = storage_path('onlylaravel/plugins.json');

        if (! File::exists($jsonPath)) {
            File::ensureDirectoryExists(dirname($jsonPath));
            $this->savePluginsJson($plugins);
            $this->plugins = $plugins;

            return true;
        }

        return true;
    }
}
