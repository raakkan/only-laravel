<?php

namespace Raakkan\OnlyLaravel\Plugin;

use Illuminate\Support\Facades\File;
use Raakkan\OnlyLaravel\Plugin\Concerns\ManageModels;
use Raakkan\OnlyLaravel\Plugin\Concerns\HasFilamentResources;

class PluginManager
{
    use ManageModels;
    protected $plugins = [];
    protected $pluginJsonManager;
    protected $onlyLaravel;
    protected $pageManager;
    protected $menuManager;
    protected $templateManager;

    public function __construct($onlyLaravel, $pageManager, $menuManager, $templateManager)
    {
        $this->onlyLaravel = $onlyLaravel;
        $this->pageManager = $pageManager;
        $this->menuManager = $menuManager;
        $this->templateManager = $templateManager;

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
            $plugin->register($this);
        }
        return $this;
    }

    public function bootActivatedPlugins()
    {
        $activatedPlugins = $this->pluginJsonManager->getActivatedPlugins();
        foreach ($activatedPlugins as $name => $activatedPlugin) {
            $plugin = $this->getPlugin($name);
            $plugin->boot($this);
        }
        return $this;
    }

    public function activatePlugin(string $name)
    {
        $this->pluginJsonManager->activatePlugin($name);
        return $this;
    }

    public function getActivatedPlugins()
    {
        return collect($this->loadPlugins())
            ->map(function ($plugin) {
                $plugin->setActivated(PluginManager::pluginIsActivated($plugin->getName()));
                return $plugin;
            })
            ->filter(function ($plugin) {
                return $plugin->isActivated();
            })->toArray();
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

    public function getOnlyLaravel()
    {
        return $this->onlyLaravel;
    }

    public function getPageManager()
    {
        return $this->pageManager;
    }

    public function getMenuManager()
    {
        return $this->menuManager;
    }

    public function getTemplateManager()
    {
        return $this->templateManager;
    }
}
