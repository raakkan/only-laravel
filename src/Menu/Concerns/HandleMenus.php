<?php

namespace Raakkan\OnlyLaravel\Menu\Concerns;
use Raakkan\OnlyLaravel\Menu\Menu;

trait HandleMenus
{
    protected $menus = [];

    public function getMenus()
    {
        return $this->menus;
    }

    public function registerMenus($menus)
    {
        foreach ($menus as $menu) {
            if ($menu instanceof Menu) {
                $this->registerMenu($menu);
            }
        }
        return $this;
    }

    public function registerMenu(Menu $menu)
    {
        if ($menu->allRequiredFieldsFilled() && ! $this->isMenuExist($menu->getName())) {
            $this->menus[] = $menu;
        }
        return $this;
    }

    public function isMenuExist($name)
    {
        return collect($this->getMenus())->first(function ($menu) use ($name) {
            return $menu->getName() == $name;
        });
    }

    public function createMenus()
    {
        foreach ($this->getMenus() as $menu) {
            $menu->create();
        }
        return $this;
    }
}