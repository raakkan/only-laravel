<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

trait HasLocation
{
    protected $location = 'default';
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
}