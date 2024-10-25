<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Components;

use Illuminate\Support\Facades\Blade;

class PageTitle extends BlockComponent
{
    protected string $name = 'page-title';

    protected string $label = 'Page Title';

    protected $group = 'core';

    protected $source = 'raakkan/only-laravel';

    public function __construct()
    {
        $this->enableCustomStyleSettingOnly(['customStyleSettings', 'customCssSettings']);
    }

    public function render()
    {
        return Blade::render(<<<'blade'
        <h1 class="{{ $blockModel->getCustomCss() }}" style="{{ $blockModel->getCustomStyle() }}">
            {!! $blockModel->title !!}
        </h1>
        blade, ['blockModel' => $this->getModel()]);
    }
}
