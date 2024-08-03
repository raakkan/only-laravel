<?php

namespace Raakkan\OnlyLaravel\Theme\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Schema;
use Raakkan\OnlyLaravel\Theme\Facades\ThemesManager;

// TODO: theme delete and page refrsh
class ThemesPage extends Page
{
    protected static string $view = 'only-laravel::theme.filament.pages.themes-page';

    protected static ?string $navigationGroup = 'Appearance';
    protected static ?string $slug = 'appearance/themes';

    public function test()
    {
        dd('test');
    }

    public function getThemes()
    {
        return ThemesManager::all();
    }

    public function getActiveTheme()
    {
        return ThemesManager::current();
    }

    public function activateTheme($themeName, $vendor)
    {
        dd($vendor . '/' . $themeName);
        ThemesManager::set($vendor . '/' . $themeName);

        // if (ThemeManagerConfig::isSettingsEnabled() && Schema::hasTable('theme_settings')) {
        //     ThemeSetting::set('current_theme', $vendor . '/' . $themeName);
        // }

        $currentTheme = ThemesManager::current();
        $currentTheme->loadThemeDBData();
        
        return redirect(request()->header('Referer'));
    }

    public function getTitle(): string
    {
        return 'Themes';
    }

    public static function getNavigationLabel(): string
    {
        return 'Themes';
    }
}
