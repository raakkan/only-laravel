<?php

namespace Raakkan\OnlyLaravel\Template\Blocks;

use Raakkan\OnlyLaravel\Facades\Theme;

class DivBlock extends Block
{
    protected string $name = 'div-block';

    protected string $label = 'Container';

    protected $group = 'core';

    protected $source = 'raakkan/only-laravel';

    protected $view = 'only-laravel::template.blocks.div';

    protected $addable = true;

    public function render()
    {
        if (Theme::hasView('core.blocks.div')) {
            return view(Theme::getThemeView('core.blocks.div'), ['block' => $this]);
        }

        return view('only-laravel::template.blocks.div', ['block' => $this]);
    }

    public function getViewPaths()
    {
        if (Theme::hasView('core.blocks.div')) {
            return [Theme::getViewPath('core.blocks.div')];
        }

        return [
            __DIR__.'/../../../resources/views/template/blocks/div.blade.php',
        ];
    }
}
