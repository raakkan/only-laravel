<?php

namespace Raakkan\OnlyLaravel\Menu\Livewire;

use Livewire\Component;
use Raakkan\OnlyLaravel\Models\MenuModel;
use Raakkan\OnlyLaravel\Models\MenuItemModel;

class MenuItemComponent extends Component
{
    public MenuModel $menu;
    public MenuItemModel $item;

    public function render()
    {
        return view('only-laravel::menu.livewire.menu-item-component');
    }
}