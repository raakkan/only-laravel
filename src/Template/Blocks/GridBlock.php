<?php

namespace Raakkan\OnlyLaravel\Template\Blocks;

class GridBlock extends Block
{
    protected string $name = 'grid';
    protected $group = 'core';
    protected $source = 'raakkan/only-laravel';

    protected $view = 'only-laravel::template.blocks.grid';

    public function getViewPaths()
    {
        return [
            resource_path('views/vendor/only-laravel/template/blocks/grid.blade.php'),
            __DIR__ . '/../../../resources/views/template/blocks/grid.blade.php',
        ];
    }
}