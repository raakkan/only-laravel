<?php

namespace Raakkan\OnlyLaravel\Template\Blocks;

class NotFoundBlock extends Block
{
    protected string $name = 'not-found-block';
    protected string $label = 'Not Found Block';

    protected $group = 'core';

    protected $source = 'raakkan/only-laravel';

    protected $sortable = false;

    public function editorRender()
    {
        return view('only-laravel::template.editor.not-found', [
            'block' => $this,
        ]);
    }

    public function render()
    {
        return '';
    }
}
