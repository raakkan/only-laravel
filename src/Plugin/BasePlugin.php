<?php

namespace Raakkan\OnlyLaravel\Plugin;

use Raakkan\OnlyLaravel\Menu\MenuManager;
use Raakkan\OnlyLaravel\Page\PageManager;
use Raakkan\OnlyLaravel\OnlyLaravelManager;
use Raakkan\OnlyLaravel\Plugin\PluginManager;
use Raakkan\OnlyLaravel\Template\FontManager;
use Raakkan\OnlyLaravel\Template\TemplateManager;

abstract class BasePlugin
{
    public function register(PluginManager $pluginManager)
    {
        //
    }

    public function boot(PluginManager $pluginManager)
    {
        //
    }

    public function onlyLaravel(OnlyLaravelManager $onlyLaravelManager)
    {
        //
    }

    public function pages(PageManager $pageManager)
    {
        //
    }

    public function menus(MenuManager $menuManager)
    {
        //
    }

    public function templates(TemplateManager $templateManager)
    {
        //
    }

    public function fonts(FontManager $fontManager)
    {
        //
    }

    public function getPages(): array
    {
        return [];
    }

    public function getTemplates(): array
    {
        return [];
    }

    public function getMenus(): array
    {
        return [];
    }
}