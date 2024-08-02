<?php

namespace Raakkan\OnlyLaravel\Theme\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Schema;

// TODO: theme delete and page refrsh
class ThemesPage extends Page
{
    protected static string $view = 'only-laravel::theme.filament.pages.themes-page';

    protected static ?string $navigationGroup = 'Appearance';
    protected static ?string $slug = 'appearance/themes';

    public function mount()
    {
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
