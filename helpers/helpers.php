<?php

use Raakkan\OnlyLaravel\Facades\TemplateManager;

if (!function_exists('theme_menus')) {
    function theme_menus($menu_name)
    {
        return \Raakkan\OnlyLaravel\Theme\Models\ThemeMenu::getMenu($menu_name);
    }
}

if (!function_exists('theme_template')) {
    function theme_template($name)
    {
        return TemplateManager::getTemplate($name);
    }
}