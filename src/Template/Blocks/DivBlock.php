<?php

namespace Raakkan\OnlyLaravel\Template\Blocks;

class DivBlock extends Block
{
    protected string $name = 'div-block';

    protected string $label = 'Container';

    protected $group = 'core';

    protected $source = 'raakkan/only-laravel';

    protected $view = 'only-laravel::template.blocks.div';

    protected $addable = true;

    public function __construct()
    {
        $this->enableCustomStyleSettingOnly(['customStyleSettings', 'customCssSettings']);
    }

    public function getViewPaths()
    {
        return [
            resource_path('views/vendor/only-laravel/template/blocks/div.blade.php'),
            __DIR__.'/../../../resources/views/template/blocks/div.blade.php',
        ];
    }
}
