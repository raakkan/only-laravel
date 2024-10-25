<?php

namespace Raakkan\OnlyLaravel\Menu\Concerns;

use Raakkan\OnlyLaravel\Menu\MenuLocation;

trait HandleMenuLocations
{
    protected $locations = [];

    public function addLocation($location)
    {
        $this->locations[] = $location;

        return $this;
    }

    public function registerLocation($location)
    {
        $this->addLocation($location);

        return $this;
    }

    public function registerLocations($locations)
    {
        foreach ($locations as $location) {
            $this->addLocation($location);
        }

        return $this;
    }

    public function getMenuLocations()
    {
        return array_merge($this->getCoreMenuLocations(), $this->locations);
    }

    public function getMenuLocationsArray()
    {
        $locations = [];
        foreach ($this->getMenuLocations() as $location) {
            $locations[$location->getName()] = $location->getLabel();
        }

        return $locations;
    }

    public function getCoreMenuLocations()
    {
        return [
            MenuLocation::make('header')->label('Header'),
            MenuLocation::make('footer')->label('Footer'),
        ];
    }
}
