<?php

namespace Raakkan\OnlyLaravel\Template\Blocks;

use Raakkan\OnlyLaravel\Template\Enums\BackgroundType;


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
    protected $view = 'only-laravel::template.blocks.footer';
    protected $addable = false;

    public function getViewPaths()
    {
        return [
            resource_path('views/vendor/only-laravel/template/blocks/footer.blade.php'),
            __DIR__ . '/../../../resources/views/template/blocks/footer.blade.php',
        ];
    }
}