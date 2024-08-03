<?php

namespace Raakkan\ThemesManager\Traits;

use Raakkan\ThemesManager\Menu\MenuLocation;

trait HasMenu
{
    public function getMenus(): array
    {
        if ($this->hasThemeClass()) {
            return $this->themeClass::getMenus();
        }

        return [];
    }
    
    public function getMenuLocations(): array
    {
        if ($this->hasThemeClass()) {
            $menuLocations = $this->themeClass::getMenuLocations();

            $locations = [];
            foreach ($menuLocations as $key => $menuLocation) {
                if ($menuLocation instanceof MenuLocation) {
                    $locations[$menuLocation->getName()] = $menuLocation->getLabel();
                }else{
                    $locations[$key] = $menuLocation;
                }
            }

            return $locations;
        }

        return [];
    }

    public function getMenuItems(): array
    {
        if ($this->hasThemeClass()) {
            return $this->themeClass::getMenuItems();
        }

        return [];
    }
}
