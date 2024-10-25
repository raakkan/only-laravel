<?php

namespace Raakkan\OnlyLaravel\Menu\Livewire;

use Livewire\Component;
use Raakkan\OnlyLaravel\Facades\MenuManager;

class MenuItemsComponent extends Component
{
    public $search = '';

    public function mount()
    {
        // dd(MenuManager::getItems());
    }

    public function getItems()
    {
        return collect(MenuManager::getItems())->filter(function ($item) {
            return ! $item->hasGroup();
        })->when($this->search, function ($items) {
            return $items->filter(function ($item) {
                return str_contains($item->getName(), $this->search);
            });
        });
    }

    public function getItemGroups()
    {
        return collect(MenuManager::getItems())->filter(function ($item) {
            return $item->hasGroup();
        })->map(function ($item) {
            return $item->getGroup();
        })->unique();
    }

    public function getGroupedItems()
    {
        return collect(MenuManager::getItems())->filter(function ($item) {
            return $item->hasGroup();
        })->when($this->search, function ($items) {
            return $items->filter(function ($item) {
                return str_contains($item->getName(), $this->search);
            });
        });
    }

    public function render()
    {
        return view('only-laravel::menu.livewire.menu-items-component');
    }
}
