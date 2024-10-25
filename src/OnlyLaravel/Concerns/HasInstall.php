<?php

namespace Raakkan\OnlyLaravel\OnlyLaravel\Concerns;

use Raakkan\OnlyLaravel\Facades\MenuManager;
use Raakkan\OnlyLaravel\Facades\PageManager;
use Raakkan\OnlyLaravel\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Plugin\Facades\PluginManager;

trait HasInstall
{
    protected $beforeInstallCallbacks = [];
    protected $afterInstallCallbacks = [];

    public function install()
    {
        $this->runBeforeInstallCallbacks();
        
        // $this->collectAndStoreSettingPages();

        //TODO: storage link and php artisan icons:cache and artisan optimize
        // artisan filament:cache-components
        // $plugins = PluginManager::loadPlugins();
        // foreach ($plugins as $plugin) {
        //     $plugin->autoload();
        //     $plugin->migrate();
        //     $plugin->createMenus();
        //     $plugin->createTemplates();
        //     $plugin->createPages();
        //     PluginManager::activatePlugin($plugin->getName());
        // }

        MenuManager::createMenus();
        TemplateManager::createTemplates();
        PageManager::createPages();

        $this->runAfterInstallCallbacks();
    }

    public function beforeInstall($callback)
    {
        if (is_callable($callback)) {
            $this->beforeInstallCallbacks[] = $callback;
        }
        return $this;
    }

    public function afterInstall($callback)
    {
        if (is_callable($callback)) {
            $this->afterInstallCallbacks[] = $callback;
        }
        return $this;
    }

    protected function runBeforeInstallCallbacks()
    {
        foreach ($this->beforeInstallCallbacks as $callback) {
            if (is_callable($callback)) {
                call_user_func($callback, $this);
            }
        }
    }

    protected function runAfterInstallCallbacks()
    {
        foreach ($this->afterInstallCallbacks as $callback) {
            if (is_callable($callback)) {
                call_user_func($callback, $this);
            }
        }
    }
}