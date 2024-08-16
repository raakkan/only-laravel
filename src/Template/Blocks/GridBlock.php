<?php

namespace Raakkan\OnlyLaravel\Template\Blocks;

class GridBlock extends Block
{
    protected string $name = 'grid';
    protected $group = 'core';
    protected $source = 'raakkan/only-laravel';

    protected $view = 'only-laravel::templates.blocks.grid';
}