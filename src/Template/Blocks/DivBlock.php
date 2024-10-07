<?php

namespace Raakkan\OnlyLaravel\Template\Blocks;

use Raakkan\OnlyLaravel\Template\Enums\BackgroundType;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasBackgroundSettings;

class DivBlock extends Block
{
    use HasBackgroundSettings;
    protected string $name = 'div-block';
    protected $group = 'core';
    protected $source = 'raakkan/only-laravel';
    protected $view = 'only-laravel::template.blocks.div';
    protected $addable = true;

    public function getViewPaths()
    {
        return [
            resource_path('views/vendor/only-laravel/template/blocks/div.blade.php'),
            __DIR__ . '/../../../resources/views/template/blocks/div.blade.php',
        ];
    }
}