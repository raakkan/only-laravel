<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Components;

use Illuminate\Support\Facades\Blade;
use Raakkan\OnlyLaravel\Facades\Theme;

class PageContent extends BlockComponent
{
    protected string $name = 'page-content';

    protected string $label = 'Page Content';

    protected $group = 'core';

    protected $source = 'raakkan/only-laravel';

    public function render()
    {
        if (Theme::hasView('core.components.page-content')) {
            return view(Theme::getThemeView('core.components.page-content'), ['block' => $this]);
        }

        return Blade::render(<<<'blade'
        <div class="{{ $block->getCustomCss() }} bg-white dark:bg-gray-800 rounded-lg p-6 text-gray-800 dark:text-gray-200" style="{{ $block->getCustomStyle() }}">
            {!! $pageModel->content !!}
        </div>
        blade, ['pageModel' => $this->getPageModel(), 'block' => $this]);
    }

    public function getViewPaths()
    {
        if (Theme::hasView('core.components.page-content')) {
            return [Theme::getViewPath('core.components.page-content')];
        }
        return [];
    }
}
