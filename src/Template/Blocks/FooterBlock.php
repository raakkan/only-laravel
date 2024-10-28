<?php

namespace Raakkan\OnlyLaravel\Template\Blocks;

use Raakkan\OnlyLaravel\Facades\Theme;

class FooterBlock extends Block
{
    protected string $name = 'footer-block';
    protected string $label = 'Footer Block';

    protected $group = 'core';

    protected $source = 'raakkan/only-laravel';

    protected $deletable = false;

    protected $sortable = false;

    protected $view = 'only-laravel::template.blocks.footer';

    protected $addable = false;

    public function render()
    {
        if (Theme::hasView('core.blocks.footer')) {
            return view(Theme::getThemeView('core.blocks.footer'), ['block' => $this]);
        }

        return view('only-laravel::template.blocks.footer', ['block' => $this]);
    }

    public function getViewPaths()
    {
        if (Theme::hasView('core.blocks.footer')) {
            return [Theme::getViewPath('core.blocks.footer')];
        }
        return [
            __DIR__.'/../../../resources/views/template/blocks/footer.blade.php',
        ];
    }
}
