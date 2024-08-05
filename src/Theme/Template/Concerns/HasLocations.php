<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Concerns;

trait HasLocations
{
    protected $locations = ['default'];
    public function locations($locations)
    {
        $this->locations = $locations;
        return $this;
    }

    public function addLocation($location)
    {
        $this->locations[] = $location;
        return $this;
    }

    public function getLocations(): array
    {
        return $this->locations;
    }
}