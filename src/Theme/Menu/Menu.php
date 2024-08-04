<?php

namespace Raakkan\OnlyLaravel\Theme\Menu;

use Illuminate\Contracts\Support\Arrayable;
use Raakkan\OnlyLaravel\Theme\Menu\MenuItem;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;

class Menu implements Arrayable
{
    use HasName;

    protected $items = [];
    protected $location;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public static function make($name)
    {
        return new static($name);
    }

    public static function makeByModel($model)
    {
        $menu = new static($model->name);
        $menu->location = $model->location;

        foreach ($model->items as $item) {
            if (!$item->hasParent()) {
                $menu->items[] = MenuItem::makeByModel($item);
            }
        }

        return $menu;
    }

    public function items($items)
    {
        $this->items = $items;
        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }
    
    public function location($location)
    {
        $this->location = $location;
        return $this;
    }

    public function hasLocation()
    {
        return isset($this->location);
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'items' => $this->items,
        ];
    }
}