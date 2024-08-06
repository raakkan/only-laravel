<?php

namespace Raakkan\OnlyLaravel\Theme\Livewire;

use Livewire\Component;
use Raakkan\OnlyLaravel\Theme\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Theme\Models\ThemeTemplateBlock;

class LivewireBlock extends Component
{
    public ThemeTemplateBlock $block;

    public function mount()
    {
        // $this->getBlockComponents();
    }

    public function getBlock()
    {
        if ($this->block->type == 'block') {
            $block = TemplateManager::getBlockByName($this->block->name)->setModel($this->block);
            $block->components($this->getBlockComponents());
        } else {
            $block = TemplateManager::getComponentByName($this->block->name)->setModel($this->block);
        };

        return $block;
    }

    public function getBlockComponents()
    {
        $components = $this->block->children ?? [];
        
        $blockComponents = [];
        foreach ($components as $component) {
            if ($component->type == 'block') {
                $blockComponents[] = TemplateManager::getBlockByName($component->name)->setModel($component);
            } else {
                $blockComponents[] = TemplateManager::getComponentByName($component->name)->setModel($component);
            }
        }
        
        return $blockComponents;
    }

    public function handleDrop(array $data, $location)
    {
        dd($data, $location);
    }

    public function render()
    {
        return view('only-laravel::theme.livewire.block');
    }
}