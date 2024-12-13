<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Components;

use Raakkan\OnlyLaravel\Admin\Forms\Components\ImageUpload;
use Raakkan\OnlyLaravel\Facades\Theme;

class DynamicHeroComponent extends BlockComponent
{
    protected string $name = 'dynamic-hero';

    protected string $label = 'Dynamic Hero';

    protected $group = 'core';

    protected $source = 'raakkan/only-laravel';

    protected $view = 'only-laravel::template.components.dynamic-hero';

    public function getBlockSettings()
    {
        return [
            ImageUpload::make('hero.image')
                ->label('Hero Image')
                ->required(),
        ];
    }

    public function render()
    {
        if (Theme::hasView('core.components.dynamic-hero')) {
            return view(Theme::getThemeView('core.components.dynamic-hero'), ['block' => $this]);
        }

        return view('only-laravel::template.components.dynamic-hero', ['block' => $this]);
    }

    public function getViewPaths()
    {
        if (Theme::hasView('core.components.dynamic-hero')) {
            return [Theme::getViewPath('core.components.dynamic-hero')];
        }

        return [
            __DIR__.'/../../../../resources/views/template/components/dynamic-hero.blade.php',
        ];
    }
}
