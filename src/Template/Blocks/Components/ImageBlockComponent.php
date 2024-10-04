<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Components;

class ImageBlockComponent extends BlockComponent
{
    protected string $name = 'image';
    protected $group = 'core';
    protected $source = 'raakkan/only-laravel';
    protected $view = 'only-laravel::template.components.image';
    protected $backgroundSettings = true;

    public function getViewPaths()
    {
        return [
            resource_path('views/vendor/only-laravel/template/components/image.blade.php'),
            __DIR__ . '/../../../../resources/views/template/components/image.blade.php',
        ];
    }
}
