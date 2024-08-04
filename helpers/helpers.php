<?php

if (!function_exists('theme_menus')) {
    function theme_menus($menu_name)
    {
        return \Raakkan\OnlyLaravel\Theme\Models\ThemeMenu::getMenu($menu_name);
    }
}