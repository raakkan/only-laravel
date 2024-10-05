<?php

namespace Raakkan\OnlyLaravel\Template\Blocks;

use Raakkan\OnlyLaravel\Template\Enums\BackgroundType;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasDesignVariant;

class NotFoundBlock extends Block
{
    use HasDesignVariant;
    protected string $name = 'not-found';
    protected $group = 'core';
    protected $source = 'raakkan/only-laravel';

    protected $sortable = false;

    public function editorRender()
    {
        return view('only-laravel::template.editor.not-found', [
            'block' => $this
        ]);
    }

    public function render()
    {
        return '';
    }
}