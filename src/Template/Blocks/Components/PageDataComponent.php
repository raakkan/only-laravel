<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Components;

use Illuminate\Support\Facades\Blade;

class PageDataComponent extends BlockComponent
{
    protected string $name = 'page-data';
    protected string $label = 'Page data';
    protected $group = 'core';
    protected $source = 'raakkan/only-laravel';

    public function getBlockSettings()
    {
        return [
        ];
    }

    public function setBlockSettings($settings)
    {
        if (is_array($settings) && array_key_exists('menu', $settings)) {
            $this->selectedMenu = $settings['menu'];
        }
        return $this;
    }

    public function render()
    {
        return '{{ $page->title }}';
    }
}
