<?php

namespace Raakkan\OnlyLaravel\Menu;

class MenuManager
{
    protected $menus = [];
    protected $locations = [];
    protected $items = [];

    public function getMenus()
    {
        return $this->menus;
    }

    public function getLocations()
    {
        return array_merge($this->getCoreMenuLocations(), $this->locations);
    }

    public function getItems()
    {
        return $this->items;
    }

    public function getCoreMenuLocations()
    {
        return [
            'header',
            'footer',
        ];
    }
}
