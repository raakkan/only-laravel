<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

trait HasChildren
{
    protected $children = [];

    public function children($childrens)
    {
        $this->children = $childrens;
        return $this;
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
        $this->children = $components;

        return $this;
    }

    public function blocks($blocks)
    {
        $this->childrens = $blocks;

        return $this;
    }

    public function hasChildren()
    {
        return count($this->children) > 0;
    }
}
