<?php

namespace Raakkan\OnlyLaravel\Template\Blocks;

use Raakkan\OnlyLaravel\Facades\Theme;

class CallToActionBlock extends Block
{
    protected string $name = 'call-to-action-block';
    protected string $label = 'Call to Action Block';

    protected $group = 'core';

    protected $source = 'raakkan/only-laravel';

    protected $deletable = false;

    protected $sortable = false;

    protected $view = 'only-laravel::template.blocks.call-to-action';

    protected $addable = false;

    public function render()
    {
        if (Theme::hasView('core.blocks.call-to-action')) {
            return view(Theme::getThemeView('core.blocks.call-to-action'), ['block' => $this]);
        }

        return view('only-laravel::template.blocks.call-to-action', ['block' => $this]);
    }

    public function getViewPaths()
    {
        if (Theme::hasView('core.blocks.call-to-action')) {
            return [Theme::getViewPath('core.blocks.call-to-action')];
        }
        return [
            __DIR__.'/../../../resources/views/template/blocks/call-to-action.blade.php',
        ];
    }
}