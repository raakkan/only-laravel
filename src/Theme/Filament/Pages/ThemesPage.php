<?php

namespace Raakkan\OnlyLaravel\Theme\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Schema;
use Raakkan\OnlyLaravel\Setting\Models\Setting;
use Raakkan\OnlyLaravel\Theme\Facades\ThemesManager;

// TODO: theme delete and page refrsh
class ThemesPage extends Page
{
    protected static string $view = 'only-laravel::theme.filament.pages.themes-page';

    protected static ?string $navigationGroup = 'Appearance';
    protected static ?string $slug = 'appearance/themes';

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
        ThemesManager::setByDatabase($vendor . '/' . $themeName);
        
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
