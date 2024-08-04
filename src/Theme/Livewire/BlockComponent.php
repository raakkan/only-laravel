<?php

namespace Raakkan\OnlyLaravel\Theme\Livewire;

use Livewire\Component;

class BlockComponent extends Component
{
    public function handleDrop(array $data)
    {
        dd($data);
    }

    public function render()
    {
        return view('only-laravel::theme.livewire.block-component');
    }
}