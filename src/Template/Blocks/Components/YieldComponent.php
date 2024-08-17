<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Components;

class YieldComponent extends BlockComponent
{
    protected string $name = 'yield';
    protected $group = 'core';
    protected $source = 'raakkan/only-laravel';
    protected $view = 'only-laravel::template.components.yield';
    protected $addable = false;
    protected $deletable = false;
    protected $disableable = false;
}
