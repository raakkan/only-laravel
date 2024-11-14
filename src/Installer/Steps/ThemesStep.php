<?php

namespace Raakkan\OnlyLaravel\Installer\Steps;

use Illuminate\View\View;
use Raakkan\OnlyLaravel\Theme\ThemeManager;

class ThemesStep extends Step
{
    public function init()
    {
    }

    public static function make(): self
    {
        return new self;
    }

    public function validate(): bool
    {
        return true;
    }

    public function getTitle(): string
    {
        return 'Step 6: Configure Themes';
    }

    public function render(): View
    {
        $themeManager = app(ThemeManager::class);
        $themeManager->updateOrCreateThemes();

        return view('only-laravel::installer.steps.themes', [
            'step' => $this,
            'themes' => $themeManager->getAllThemes(),
        ]);
    }
} 