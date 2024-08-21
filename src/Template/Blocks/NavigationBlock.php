<?php

namespace Raakkan\OnlyLaravel\Template\Blocks;

use Raakkan\OnlyLaravel\Template\Blocks\Concerns\HasNavigationBlock;
use Raakkan\OnlyLaravel\Template\Enums\BackgroundType;

class NavigationBlock extends Block
{
    use HasNavigationBlock;
    protected string $name = 'navigation-block';
    protected $group = 'core';
    protected $source = 'raakkan/only-laravel';
    protected $backgroundSettings = true;
    protected $fontSettings = true;

    protected $backgroundType = BackgroundType::COLOR;
    public $backgroundColor = '#ffffff';
    protected $textColorSettings = true;

    protected $view = 'only-laravel::template.blocks.navigation';

    public function editorRender()
    {
        return view('only-laravel::template.editor.navigation', [
            'block' => $this
        ]);
    }
}