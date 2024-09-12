<?php

namespace Raakkan\OnlyLaravel\Plugin;

abstract class BasePlugin
{
    public function filamentResources(): array
    {
        return [];
    }

    public function filamentPages(): array
    {
        return [];
    }

    public function filamentNavigationGroups(): array
    {
        return [];
    }

    public function getRoutes(): array
    {
        return [];
    }

    public function getPageTypes(): array
    {
        return [];
    }

    public function getPageTypeExternalModelPages(): array
    {
        return [];
    }
}