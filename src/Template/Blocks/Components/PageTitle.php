<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Components;

use Illuminate\Support\Facades\Blade;
use Raakkan\OnlyLaravel\Facades\Theme;

class PageTitle extends BlockComponent
{
    protected string $name = 'page-title';

    protected string $label = 'Page Title';

    protected $group = 'core';

    protected $source = 'raakkan/only-laravel';
    public function render()
    {
        if (Theme::hasView('core.components.page-title')) {
            return view(Theme::getThemeView('core.components.page-title'), ['block' => $this]);
        }
        return Blade::render(<<<'blade'
        <h1 class="{{ $blockModel->getCustomCss() }}" style="{{ $blockModel->getCustomStyle() }}">
            {!! $blockModel->title !!}
        </h1>
        blade, ['blockModel' => $this->getModel()]);
    }

    public function getViewPaths()
    {
        if (Theme::hasView('core.components.page-title')) {
            return [Theme::getViewPath('core.components.page-title')];
        }
        return [];
    }
}
