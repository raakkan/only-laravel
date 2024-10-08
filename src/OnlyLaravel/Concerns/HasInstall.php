<?php

namespace Raakkan\OnlyLaravel\OnlyLaravel\Concerns;

use Raakkan\OnlyLaravel\Facades\MenuManager;
use Raakkan\OnlyLaravel\Facades\PageManager;
use Raakkan\OnlyLaravel\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Plugin\Facades\PluginManager;

trait HasInstall
{
    public function install()
    {
        $plugins = PluginManager::loadPlugins();
        foreach ($plugins as $plugin) {
            $plugin->autoload();
            $plugin->migrate();
            $plugin->createMenus();
            $plugin->createTemplates();
            $plugin->createPages();
            PluginManager::activatePlugin($plugin->getName());
        }

        MenuManager::createMenus();
        TemplateManager::createTemplates();
        PageManager::createPages();
    }
}