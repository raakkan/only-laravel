<?php

namespace Raakkan\OnlyLaravel\Plugin;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Raakkan\OnlyLaravel\Plugin\Models\PluginModel;
use Raakkan\OnlyLaravel\Plugin\Traits\HandlesPluginOperations;

class PluginManager
{
    use HandlesPluginOperations;

    protected Collection $plugins;

    protected string $pluginsPath;

    protected Collection $activePlugins;

    public function __construct()
    {
        $this->pluginsPath = base_path('plugins');
        $this->plugins = new Collection;
        $this->activePlugins = new Collection;
        $this->loadPlugins();
    }

    public function loadPlugins(): void
    {
        if (! File::exists($this->pluginsPath)) {
            File::makeDirectory($this->pluginsPath, 0755, true);
        }

        $pluginFolders = File::directories($this->pluginsPath);

        foreach ($pluginFolders as $pluginFolder) {
            $pluginJsonPath = $pluginFolder.'/plugin.json';
            $pluginJson = new PluginJson($pluginJsonPath);

            if ($pluginJson->isValid()) {
                $this->plugins->put($pluginJson->getName(), [
                    'path' => $pluginFolder,
                    'json' => $pluginJson,
                    'config' => $pluginJson->toArray(),
                ]);
            }
        }
    }

    public function updateOrCreatePlugins(): void
    {
        $this->plugins->each(function ($plugin) {
            $existingPlugin = PluginModel::where('name', $plugin['json']->getName())->first();

            if ($existingPlugin) {
                $jsonVersion = $plugin['config']['version'] ?? '0.0.0';
                $dbVersion = $existingPlugin->version ?? '0.0.0';

                if (version_compare($jsonVersion, $dbVersion, '>')) {
                    $existingPlugin->update(['update_available' => true]);
                }
            } else {
                PluginModel::create($plugin['config']);
            }
        });
    }

    public function bootActivatedPlugins(): void
    {
        $this->getActivePlugins()->each(function ($plugin) {
            $this->bootPlugin($plugin);
        });
    }

    public function getAllPlugins(): Collection
    {
        return PluginModel::all();
    }

    public function getPlugin(string $name): ?PluginModel
    {
        return PluginModel::where('name', $name)->first();
    }

    public function getActivePlugins(): Collection
    {
        if ($this->activePlugins->isEmpty()) {
            $this->activePlugins = PluginModel::activePlugins();
        }

        return $this->activePlugins;
    }

    public function getPluginJson(string $name): ?PluginJson
    {
        $pluginPath = $this->getPluginPath($name);
        if ($pluginPath) {
            $pluginJsonPath = $pluginPath.'/plugin.json';
            return new PluginJson($pluginJsonPath);
        }

        return null;
    }

    public function activatePlugin(string $name): bool
    {
        $plugin = $this->getPlugin($name);

        if (! $plugin) {
            return false;
        }

        $activated = $plugin->activate();

        if ($activated) {
            $this->activePlugins = PluginModel::activePlugins();
            // Register plugin specific functionality here if needed
            $this->registerPlugin($plugin);
        }

        return $activated;
    }

    public function deactivatePlugin(string $name): bool
    {
        $plugin = $this->getPlugin($name);
        
        if (! $plugin) {
            return false;
        }

        $deactivated = $plugin->update(['is_active' => false]);

        if ($deactivated) {
            cache()->forget('active_plugins');
            $this->activePlugins = PluginModel::activePlugins();
        }

        return $deactivated;
    }

    public function updatePlugin(string $name): bool
    {
        $plugin = $this->getPlugin($name);
        if (! $plugin) {
            return false;
        }

        return $plugin->updatePlugin();
    }

    public function pluginExists(string $name): bool
    {
        return PluginModel::where('name', $name)->exists();
    }

    public function getPluginPath(string $name): ?string
    {
        return $this->plugins->get($name)['path'] ?? null;
    }

    public function isPluginActive(string $name): bool
    {
        return $this->getActivePlugins()->contains('name', $name);
    }
}
