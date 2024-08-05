<?php

namespace Raakkan\OnlyLaravel\Theme\Livewire;

use Livewire\Component;
use Raakkan\OnlyLaravel\Theme\Template\Blocks\Block;
use Raakkan\OnlyLaravel\Theme\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Theme\Template\Blocks\Items\BlockItem;

class BlockItemsComponent extends Component
{
    public function mount()
    {
        TemplateManager::collectThemeBlocksAndComponents();
    }

    public function getBlocks()
    {
        return collect(TemplateManager::getBlocks())->filter(function ($block) {
            return !$block->hasGroup();
        });
    }

    public function getBlockGroups()
    {
        return collect(TemplateManager::getBlocks())->filter(function ($block) {
            return $block->hasGroup();
        })->map(function ($block) {
            return $block->getGroup();
        })->unique();
    }

    public function getGrouppedBlocks()
    {
        return collect(TemplateManager::getBlocks())->filter(function ($block) {
            return $block->hasGroup();
        });
    }

    public function getComponents()
    {
        return collect(TemplateManager::getBlockComponents())->filter(function ($item) {
            return !$item->hasGroup();
        });
    }

    public function getComponentGroups()
    {
        return collect(TemplateManager::getBlockComponents())->filter(function ($item) {
            return $item->hasGroup();
        })->map(function ($item) {
            return $item->getGroup();
        })->unique();
    }

    public function getGrouppedComponents()
    {
        return collect(TemplateManager::getBlockComponents())->filter(function ($item) {
            return $item->hasGroup();
        });
    }

    public function render()
    {
        return view('only-laravel::theme.livewire.block-items-component');
    }
}