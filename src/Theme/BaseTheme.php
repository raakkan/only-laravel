<?php

namespace Raakkan\OnlyLaravel\Theme;

abstract class BaseTheme
{
    public static function getTemplates(): array
    {
        return [];
    }

    public static function getFilamentPages(): array
    {
        return [];
    }

    public static function getMenus(): array
    {
        return [];
    }

    public static function getMenuItems(): array
    {
        return [];
    }

    public static function getMenuLocations(): array
    {
        return [
            'header' => 'Header',
            'footer' => 'Footer',
        ];
    }
}
