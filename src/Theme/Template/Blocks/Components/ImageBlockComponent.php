<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Blocks\Components;

class ImageBlockComponent extends BlockComponent
{
    protected string $name = 'image';
    protected $type = 'image';
    protected $group = 'core';
    protected $source = 'raakkan/only-laravel';

    public function __construct()
    {
    }
}
