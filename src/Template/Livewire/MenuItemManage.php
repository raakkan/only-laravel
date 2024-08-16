<?php

namespace Raakkan\OnlyLaravel\Theme\Livewire;

use Livewire\Component;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Raakkan\OnlyLaravel\Models\MenuModel;
use Filament\Actions\Contracts\HasActions;
use Raakkan\OnlyLaravel\Models\MenuItemModel;
use Filament\Forms\Concerns\InteractsWithForms;
use Raakkan\OnlyLaravel\Setting\Models\Setting;
use Filament\Actions\Concerns\InteractsWithActions;

class MenuItemManage extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;
    
    public MenuModel $menu;

    public $menuItems;

    public $selectedItem;

    public function mount()
    {
        $this->menuItems = $this->menu->items()->with('children')->whereNull('parent_id')->orderBy('order')->get();
    }

    public function addMenuItem($item)
    {
        MenuItemModel::addMenuItem($this->menu, array_merge($item, ['source' => $this->getActiveThemeNamespace()]));
        Notification::make()
                    ->title('Menu item added')
                    ->success()
                    ->send();
        $this->menuItems = $this->menu->items()->with('children')->whereNull('parent_id')->orderBy('order')->get();
    }

    public function addAsChild($item)
    {
        if ($this->selectedItem) {
            MenuItemModel::addAsChild($this->menu, array_merge($item, ['source' => $this->getActiveThemeNamespace()]), $this->selectedItem['id']);
            Notification::make()
                    ->title('Menu item added')
                    ->success()
                    ->send();
            $this->menuItems = $this->menu->items()->with('children')->whereNull('parent_id')->orderBy('order')->get();
        }
    }

    public function updateMenuItemOrder($itemId, $position)
    {
        $menuItem = MenuItemModel::find($itemId);
        
        if ($menuItem) {
            $menuItem->updateOrder($position);
            $this->menuItems = $this->menu->items()->with('children')->whereNull('parent_id')->orderBy('order')->get();
        }
    }

    public function getMenuItems(): array
    {
        if(Setting::getCurrentTheme() === null) {
            return [];
        }

        $themeItems = ThemesManager::get(Setting::getCurrentTheme())->getMenuItems();

        $menuItems = [];

        foreach ($themeItems as $item) {
            if ($item->getType() === 'item') {
                $menuItems[] = $item;
            }
        }

        return $menuItems;
    }

    public function getMenuItemGroups(): array
    {
        if(Setting::getCurrentTheme() === null) {
            return [];
        }
        $themeItems = ThemesManager::get(Setting::getCurrentTheme())->getMenuItems();
        
        $menuItemGroups = [];
        foreach ($themeItems as $item) {
            if ($item->getType() === 'group') {
                $menuItemGroups[] = $item;
            }
        }

        return $menuItemGroups;
    }

    public function setSelectedItem($item)
    {
        $this->selectedItem = $item;
    }

    public function getSelectedItem()
    {
        return MenuItemModel::find($this->selectedItem['id']);
    }

    public function editAction(): Action
    {
        return EditAction::make('edit')
        ->record($this->getSelectedItem())
            ->label('Edit')
            ->link()
            ->color('info')
            ->form([
                TextInput::make('name')->required(),
                TextInput::make('url')->required(),
            ])
            ->action(function (array $data) {
                $this->getSelectedItem()->update($data);
                Notification::make()
                    ->title('Menu item updated')
                    ->success()
                    ->send();
                $this->menuItems = $this->menu->items()->with('children')->whereNull('parent_id')->orderBy('order')->get();
            });
    }

    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->requiresConfirmation()
            ->link()
            ->color('danger')
            ->action(function () {
                $order = $this->getSelectedItem()->order;
                $parent = $this->getSelectedItem()->parent_id;
                $this->getSelectedItem()->delete();
                MenuItemModel::reorderSiblings($this->menu, $order, $parent);
                Notification::make()
                    ->title('Menu item deleted')
                    ->success()
                    ->send();
                $this->menuItems = $this->menu->items()->with('children')->whereNull('parent_id')->orderBy('order')->get();
                $this->selectedItem = null;
            });
    }

    public function getActiveThemeNamespace()
    {
        if(Setting::getCurrentTheme() === null) {
            return '';
        }

        return ThemesManager::current()->getNamespace();
    }

    public function render()
    {
        return view('only-laravel::theme.livewire.menu-item-manage');
    }
}