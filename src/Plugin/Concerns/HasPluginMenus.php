<?php

namespace Raakkan\OnlyLaravel\Plugin\Concerns;

trait HasPluginMenus
{
    public function getMenus(): array
    {
        $pluginClass = $this->getPluginClass();

        return $pluginClass->getMenus();
    }

    public function createMenus()
    {
        $menus = $this->getMenus();

        foreach ($menus as $menu) {
            $menu->create();
        }
    }
}
