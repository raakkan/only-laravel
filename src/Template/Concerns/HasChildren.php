<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

trait HasChildren
{
    protected $children = [];

    public function children($childrens)
    {
        return $this->blocks($childrens);
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function getChildrenByLocation($location)
    {
        return collect($this->children)->filter(function ($children) use ($location) {
            return $children->getLocation() == $location;
        })->all();
    }

    public function components($components)
    {
        return $this->blocks($components);
    }

    public function blocks($blocks)
    {
        $this->children = $blocks;

        return $this;
    }

    public function hasChildren()
    {
        return count($this->children) > 0;
    }
}
