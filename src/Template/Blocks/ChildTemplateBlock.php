<?php

namespace Raakkan\OnlyLaravel\Template\Blocks;

use Illuminate\Support\Facades\Blade;

class ChildTemplateBlock extends Block
{
    protected string $name = 'child-template-block';

    protected string $label = 'Child Template';

    protected $group = 'core';

    protected $source = 'raakkan/only-laravel';

    protected $deletable = false;

    protected $disableable = false;

    protected $addable = false;

    protected $customStyleSettings = false;

    protected $customCssSettings = false;

    protected $acceptDropChild = false;

    public function render()
    {
        return Blade::render(<<<'blade'
            @php
                $childrens = $block->getChildren();
            @endphp

            @foreach ($childrens as $child)
                {!! $child->render() !!}
            @endforeach
            blade, ['block' => $this]);
    }
}
