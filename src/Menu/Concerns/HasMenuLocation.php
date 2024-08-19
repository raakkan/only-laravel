<?php

namespace Raakkan\OnlyLaravel\Menu\Concerns;

trait HasMenuLocation
{
    protected $location;
    public function location($location)
    {
        $this->location = $location;
        return $this;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location)
    {
        $this->location = $location;
        return $this;
    }

    public function hasLocation()
    {
        return !empty($this->location) && !is_null($this->location);
    }
}