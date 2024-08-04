<?php

namespace Raakkan\OnlyLaravel\Theme\Traits;

use Raakkan\OnlyLaravel\Theme\Menu\Menu;
use Raakkan\OnlyLaravel\Theme\Models\ThemeMenu;
use Raakkan\OnlyLaravel\Theme\Menu\MenuItemGroup;

trait HasDbActions
{
    public function loadThemeDBData()
    {
        $this->loadMenus();
    }

    public function loadMenus()
    {
        $menus = $this->getMenus();
        $namespace = $this->getNamespace();

        foreach ($menus as $menu) {
            if ($menu instanceof Menu && $menu->hasLocation()) {
                $themeMenu = ThemeMenu::updateOrCreate([
                    'name' => $menu->getName(),
                    'location' => $menu->getLocation(),
                    'source' => $namespace,
                ]);

                $this->updateOrCreateMenuItems($menu->getItems(), $themeMenu, $namespace);
            }
        }

        return $this;
    }

    private function updateOrCreateMenuItems($items, $themeMenu, $namespace, $parentMenuItem = null)
    {
        foreach ($items as $index => $item) {
            if ($item instanceof MenuItemGroup) {
                foreach ($item->getItems() as $subIndex => $subItem) {
                    $this->createMenuItem($subItem, $themeMenu, $namespace, $parentMenuItem);
                    
                }
            } else {
                $themeMenuItem = $this->createMenuItem($item, $themeMenu, $namespace, $parentMenuItem);

                if ($item->hasChildren()) {
                    $this->updateOrCreateMenuItems($item->getChildren(), $themeMenu, $namespace, $themeMenuItem);
                }
            }
        }
    }

    private function createMenuItem($item, $themeMenu, $namespace, $parentMenuItem = null)
    {
        $order = 1;

        if ($parentMenuItem) {
            $lastItem = $parentMenuItem->children()->latest('order')->first();
        } else {
            $lastItem = $themeMenu->items()->whereNull('parent_id')->latest('order')->first();
        }

        if ($lastItem) {
            $order = $lastItem->order + 1;
        }

        $attributes = [
            'name' => $item->getName(),
            'label' => $item->getLabel(),
            'url' => $item->getUrl(),
            'icon' => $item->getIcon(),
            'order' => $order,
            'menu_id' => $themeMenu->id,
            'source' => $namespace,
        ];

        if ($parentMenuItem) {
            return $parentMenuItem->children()->updateOrCreate([
                'name' => $item->getName(),
                'parent_id' => $parentMenuItem->id,
                'source' => $namespace,
            ], $attributes);
        } else {
            return $themeMenu->items()->updateOrCreate([
                'name' => $item->getName(),
                'source' => $namespace,
            ], $attributes);
        }
    }

}
