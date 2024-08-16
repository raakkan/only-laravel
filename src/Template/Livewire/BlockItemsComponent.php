<?php

namespace Raakkan\OnlyLaravel\Template\Livewire;

use Livewire\Component;
use Raakkan\OnlyLaravel\Facades\TemplateManager;

class BlockItemsComponent extends Component
{
    public function mount()
    {
    }

    public function getBlocks()
    {
        return collect(TemplateManager::getBlocks())->filter(function ($block) {
            return !$block->hasGroup() && $block->getType() == 'block' && $block->isAddable();
        });
    }

    public function getBlockGroups()
    {
        return collect(TemplateManager::getBlocks())->filter(function ($block) {
            return $block->hasGroup() && $block->getType() == 'block' && $block->isAddable();
        })->map(function ($block) {
            return $block->getGroup();
        })->unique();
    }

    public function getGrouppedBlocks()
    {
        return collect(TemplateManager::getBlocks())->filter(function ($block) {
            return $block->hasGroup() && $block->getType() == 'block' && $block->isAddable();
        });
    }

    public function getComponents()
    {
        return collect(TemplateManager::getBlocks())->filter(function ($item) {
            return !$item->hasGroup() && $item->getType() == 'component' && $item->isAddable();
        });
    }

    public function getComponentGroups()
    {
        return collect(TemplateManager::getBlocks())->filter(function ($item) {
            return $item->hasGroup() && $item->getType() == 'component' && $item->isAddable();
        })->map(function ($item) {
            return $item->getGroup();
        })->unique();
    }

    public function getGrouppedComponents()
    {
        return collect(TemplateManager::getBlocks())->filter(function ($item) {
            return $item->hasGroup() && $item->getType() == 'component' && $item->isAddable();
        });
    }

    public function render()
    {
        return view('only-laravel::theme.livewire.block-items-component');
    }
}