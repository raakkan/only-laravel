<?php

namespace Raakkan\OnlyLaravel\Theme\Livewire;

use Livewire\Component;
use Raakkan\OnlyLaravel\Theme\Facades\TemplateManager;

class BlockComponent extends Component
{
    public $block = [];

    public function getBlock()
    {
        return TemplateManager::getBlockByName($this->block['name']);
    }

    public function handleDrop(array $data)
    {
        dd($data);
    }

    public function render()
    {
        return view('only-laravel::theme.livewire.block-component');
    }
}