<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Concerns;

trait HasBlockComponents
{
    protected $components = [];

    public function getComponents()
    {
        return $this->components;
    }

    public function components($components)
    {
        $this->components = $components;

        return $this;
    }

    public function addComponent($component)
    {
        $this->components[] = $component;
        
        return $this;
    }

    public function removeComponent($component)
    {
        $index = array_search($component, $this->components);
        if ($index !== false) {
            unset($this->components[$index]);
        }
        return $this;
    }

    public function clearComponents()
    {
        $this->components = [];
        return $this;
    }

    public function setComponents($components)
    {
        $this->components = $components;
        return $this;
    }
}
