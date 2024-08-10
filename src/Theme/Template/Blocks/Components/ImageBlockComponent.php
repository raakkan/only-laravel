<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Blocks\Components;

class ImageBlockComponent extends BlockComponent
{
    protected string $name = 'image';
    protected $group = 'core';
    protected $source = 'raakkan/only-laravel';
    protected $view = 'only-laravel::templates.components.image';
}
