<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Blocks\Components;

class YieldComponent extends BlockComponent
{
    protected string $name = 'yield';
    protected $group = 'core';
    protected $source = 'raakkan/only-laravel';
    protected $view = 'only-laravel::templates.components.yield';
    protected $addable = false;
}
