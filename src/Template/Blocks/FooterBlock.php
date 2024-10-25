<?php

namespace Raakkan\OnlyLaravel\Template\Blocks;

class FooterBlock extends Block
{
    protected string $name = 'footer-block';

    protected $group = 'core';

    protected $source = 'raakkan/only-laravel';

    protected $deletable = false;

    protected $sortable = false;

    protected $view = 'only-laravel::template.blocks.footer';

    protected $addable = false;

    public function __construct()
    {
        $this->enableCustomStyleSettingOnly(['customStyleSettings', 'customCssSettings']);
    }

    public function getViewPaths()
    {
        return [
            resource_path('views/vendor/only-laravel/template/blocks/footer.blade.php'),
            __DIR__.'/../../../resources/views/template/blocks/footer.blade.php',
        ];
    }
}
