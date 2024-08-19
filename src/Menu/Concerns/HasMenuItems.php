<?php

namespace Raakkan\OnlyLaravel\Menu\Concerns;

trait HasMenuItems
{
    protected $items = [];
    public function items($items)
    {
        $this->items = $items;
        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function hasItems()
    {
        return count($this->items) > 0;
    }
}