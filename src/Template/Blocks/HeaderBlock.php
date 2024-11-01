<?php

namespace Raakkan\OnlyLaravel\Template\Blocks;

use Raakkan\OnlyLaravel\Facades\Theme;

class HeaderBlock extends Block
{
    protected string $name = 'header-block';

    protected string $label = 'Header Block';

    protected $group = 'core';

    protected $source = 'raakkan/only-laravel';

    protected $deletable = false;

    protected $sortable = false;

    protected $view = 'only-laravel::template.blocks.header';

    protected $addable = false;

    public function render()
    {
        if (Theme::hasView('core.blocks.header')) {
            return view(Theme::getThemeView('core.blocks.header'), ['block' => $this]);
        }

        return view('only-laravel::template.blocks.header', ['block' => $this]);
    }

    public function getViewPaths()
    {
        if (Theme::hasView('core.blocks.header')) {
            return [Theme::getViewPath('core.blocks.header')];
        }

        return [
            __DIR__.'/../../../resources/views/template/blocks/header.blade.php',
        ];
    }
}
