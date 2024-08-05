<?php

namespace Raakkan\OnlyLaravel\Theme\Filament\Pages;

use Filament\Pages\Page;
use Raakkan\OnlyLaravel\Theme\Facades\ThemesManager;
use Raakkan\OnlyLaravel\Theme\Models\ThemeTemplate;

class TemplatePage extends Page
{
    protected static string $view = 'only-laravel::theme.filament.pages.template-page';

    protected static ?string $navigationGroup = 'Appearance';
    protected static ?string $slug = 'appearance/templates';
    public $template;

    public function mount()
    {
        $this->getTemplate()->create();

        $this->template = ThemeTemplate::first();
    }

    public function getTemplate()
    {
        return $this->getActiveTheme()->getTemplates()[0];
    }

    public function getActiveTheme()
    {
        return ThemesManager::current();
    }

    public function getTitle(): string
    {
        return 'Templates';
    }

    public static function getNavigationLabel(): string
    {
        return 'Templates';
    }
}