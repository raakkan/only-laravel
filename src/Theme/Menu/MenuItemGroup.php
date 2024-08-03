<?php

namespace Raakkan\ThemesManager\Menu;

use Illuminate\Contracts\Support\Arrayable;
use Raakkan\ThemesManager\Support\Traits\HasName;

class MenuItemGroup implements Arrayable
{
    use HasName;
    protected $items = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public static function make($name)
    {
        return new static($name);
    }

    public function items($items)
    {
        $this->items = $items;
        return $this;
    }

    public function addItem($item)
    {
        $this->items[] = $item;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function getType()
    {
        return 'group';
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'items' => $this->items,
        ];
    }
}