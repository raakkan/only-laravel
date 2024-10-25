<?php

namespace Raakkan\OnlyLaravel\Menu\Livewire;

use Filament\Notifications\Notification;
use Livewire\Attributes\On;
use Livewire\Component;
use Raakkan\OnlyLaravel\Models\MenuItemModel;
use Raakkan\OnlyLaravel\Models\MenuModel;

class MenuItemsManage extends Component
{
    public MenuModel $menu;

    #[On('item-deleted')]
    public function itemDeleted()
    {
        $this->menu->refresh();
    }

    public function handleDrop(array $data)
    {
        $itemsCount = $this->menu->items()->where('parent_id', null)->count();

        $item = $this->menu->items()->create([
            'name' => $data['name'],
            'order' => $itemsCount === 0 ? 0 : $itemsCount++,
            'url' => $data['url'],
            'icon' => $data['icon'],
            'label' => $data['label'],
        ]);

        Notification::make()
            ->title('Menu item created')
            ->success()
            ->send();
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
