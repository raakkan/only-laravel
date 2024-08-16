<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

trait HasChildren
{
    protected $childrens = [];

    public function childrens($childrens)
    {
        $this->childrens = $childrens;
        return $this;
    }

    public function getChildrens()
    {
        return $this->childrens;
    }

    public function getChildrensByLocation($location)
    {
        return collect($this->childrens)->filter(function ($children) use ($location) {
            return $children->getLocation() == $location;
        })->all();
    }

    public function components($components)
    {
        $this->childrens = $components;

        return $this;
    }

    public function blocks($blocks)
    {
        $this->childrens = $blocks;

        return $this;
    }
}
