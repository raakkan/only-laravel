<?php

namespace Raakkan\OnlyLaravel\Menu\Livewire;

use Livewire\Component;
use Raakkan\OnlyLaravel\Models\MenuItemModel;
use Raakkan\OnlyLaravel\Models\MenuModel;

class MenuItemsManage extends Component
{
    public MenuModel $menu;

    public function handleDrop(array $data)
    {
        dd($data);
    }

    public function updateOrder($itemId, $position)
    {
        $item = MenuItemModel::find($itemId);
        $item->updateOrder($position);
    }

    public function render()
    {
        return view('only-laravel::menu.livewire.menu-items-manage');
    }
}