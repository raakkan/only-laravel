<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Components;

use Illuminate\Support\Facades\Blade;

class PageContent extends BlockComponent
{
    protected string $name = 'page-content';

    protected string $label = 'Page Content';

    protected $group = 'core';

    protected $source = 'raakkan/only-laravel';

    public function __construct()
    {
        $this->enableCustomStyleSettingOnly(['customStyleSettings', 'customCssSettings']);
    }

    public function render()
    {
        return Blade::render(<<<'blade'
        <div class="{{ $block->getCustomCss() }}" style="{{ $block->getCustomStyle() }}">
            {!! $blockModel->content !!}
        </div>
        blade, ['blockModel' => $this->getModel(), 'block' => $this]);
    }
}
