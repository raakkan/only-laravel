<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Components;

use Illuminate\Support\Facades\Blade;
use Raakkan\OnlyLaravel\Facades\Theme;

class PageFeaturedImage extends BlockComponent
{
    protected string $name = 'page-featured-image';

    protected string $label = 'Page Featured Image';

    protected $group = 'core';

    protected $source = 'raakkan/only-laravel';

    public function render()
    {
        $pageModel = $this->getPageModel();
        
        if (!$pageModel->featured_image) {
            return '';
        }

        if (Theme::hasView('core.components.page-featured-image')) {
            return view(Theme::getThemeView('core.components.page-featured-image'), ['block' => $this]);
        }

        return Blade::render(<<<'blade'
        <div class="{{ $block->getCustomCss() }} bg-white dark:bg-gray-800 rounded-lg overflow-hidden" style="{{ $block->getCustomStyle() }}">
            <img src="{{ $pageModel->featured_image }}" alt="{{ $pageModel->title }}" class="w-full h-auto">
        </div>
        blade, ['pageModel' => $pageModel, 'block' => $this]);
    }

    public function getViewPaths()
    {
        if (Theme::hasView('core.components.page-featured-image')) {
            return [Theme::getViewPath('core.components.page-featured-image')];
        }

        return [];
    }
}
