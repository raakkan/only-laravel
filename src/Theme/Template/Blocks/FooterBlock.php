<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Blocks;

use Raakkan\OnlyLaravel\Theme\Enums\BackgroundType;

class FooterBlock extends Block
{
    protected string $name = 'footer';
    protected $group = 'core';
    protected $source = 'raakkan/only-laravel';
    protected $deletable = false;
    protected $sortable = false;
    protected $backgroundSettings = true;
    protected $backgroundType = BackgroundType::COLOR;
    protected $background = [
        'color' => '#00e693',
    ];
    protected $view = 'only-laravel::templates.blocks.footer';
}