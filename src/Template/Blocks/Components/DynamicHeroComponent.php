<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Components;

class DynamicHeroComponent extends BlockComponent
{
    protected string $name = 'dynamic-hero';

    protected string $label = 'Dynamic Hero';

    protected $group = 'core';

    protected $source = 'raakkan/only-laravel';

    protected $view = 'only-laravel::template.components.dynamic-hero';

    public function __construct()
    {
        $this->enableCustomStyleSettingOnly(['customStyleSettings', 'customCssSettings']);
    }

    public function getViewPaths()
    {
        return [
            resource_path('views/vendor/only-laravel/template/components/dynamic-hero.blade.php'),
            __DIR__.'/../../../../resources/views/template/components/dynamic-hero.blade.php',
        ];
    }
}
