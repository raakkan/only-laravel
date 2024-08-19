<?php

namespace Raakkan\OnlyLaravel\Menu\Concerns;

use Raakkan\OnlyLaravel\Menu\MenuItem;

trait HasMenuItemChildren
{
    protected $children = [];
    public function children($children)
    {
        foreach ($children as $child) {
            if ($child instanceof MenuItem) {
                $this->setChild($child);
            }
        }
        return $this;
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function hasChildren()
    {
        return count($this->children) > 0;
    }

    public function setChildren($children)
    {
        $this->children[] = $children;
        return $this;
    }

    public function setChild($child)
    {
        $this->children[] = $child;
        return $this;
    }
}