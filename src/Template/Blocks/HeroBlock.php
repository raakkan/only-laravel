<?php

namespace Raakkan\OnlyLaravel\Template\Blocks;

use Raakkan\OnlyLaravel\Facades\Theme;

class HeroBlock extends Block
{
    protected string $name = 'hero-block';
    protected string $label = 'Hero Block';

    protected $group = 'core';

    protected $source = 'raakkan/only-laravel';

    protected $deletable = false;

    protected $sortable = false;

    protected $view = 'only-laravel::template.blocks.hero';

    protected $addable = false;

    public function render()
    {
        if (Theme::hasView('core.blocks.hero')) {
            return view(Theme::getThemeView('core.blocks.hero'), ['block' => $this]);
        }

        return view('only-laravel::template.blocks.hero', ['block' => $this]);
    }

    public function getViewPaths()
    {
        if (Theme::hasView('core.blocks.hero')) {
            return [Theme::getViewPath('core.blocks.hero')];
        }
        return [
            __DIR__.'/../../../resources/views/template/blocks/hero.blade.php',
        ];
    }
}