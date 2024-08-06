<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Concerns;

trait HasBlockComponents
{
    protected $components = [];

    public function getComponents()
    {
        return $this->components;
    }

    public function getComponentsByLocation($location)
    {
        return collect($this->components)->filter(function ($component) use ($location) {
            return $component->getLocation() == $location;
        })->all();
    }

    public function components($components)
    {
        $this->components = $components;

        return $this;
    }

    public function setComponents($components)
    {
        $this->components = $components;
        return $this;
    }
}
