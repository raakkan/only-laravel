<?php

namespace Raakkan\OnlyLaravel\Theme\Livewire;

use Livewire\Component;
use Raakkan\OnlyLaravel\Theme\Facades\TemplateManager;

class LivewireBlock extends Component
{
    public $block;

    public function mount()
    {
        // $this->getBlockComponents();
    }

    public function getBlock()
    {
        $block = TemplateManager::getBlockByName($this->block->name)->setModelData($this->block);

        $block->components($this->getBlockComponents());

        return $block;
    }

    public function getBlockComponents()
    {
        $components = $this->block->children ?? [];
        
        $blockComponents = [];
        foreach ($components as $component) {
            if ($component->type == 'block') {
                $blockComponents[] = TemplateManager::getBlockByName($component->name)->setModelData($component);
            } else {
                $blockComponents[] = TemplateManager::getComponentByName($component->name)->setModelData($component);
            }
        }

        return $blockComponents;
    }

    public function handleDrop(array $data)
    {
        dd($data);
    }

    public function render()
    {
        return view('only-laravel::theme.livewire.block');
    }
}