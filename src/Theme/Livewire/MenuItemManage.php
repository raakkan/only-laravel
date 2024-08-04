<?php

namespace Raakkan\OnlyLaravel\Theme\Livewire;

use Livewire\Component;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Raakkan\OnlyLaravel\Setting\Models\Setting;
use Raakkan\OnlyLaravel\Theme\Models\ThemeMenu;
use Filament\Actions\Concerns\InteractsWithActions;
use Raakkan\OnlyLaravel\Theme\Models\ThemeMenuItem;
use Raakkan\OnlyLaravel\Theme\Facades\ThemesManager;

class MenuItemManage extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;
    
    public ThemeMenu $menu;

    public $menuItems;

    public $selectedItem;

    public function mount()
    {
        $this->menuItems = $this->menu->items()->with('children')->whereNull('parent_id')->orderBy('order')->get();
    }

    public function addMenuItem($item)
    {
        ThemeMenuItem::addMenuItem($this->menu, array_merge($item, ['source' => $this->getActiveThemeNamespace()]));
        Notification::make()
                    ->title('Menu item added')
                    ->success()
                    ->send();
        $this->menuItems = $this->menu->items()->with('children')->whereNull('parent_id')->orderBy('order')->get();
    }

    public function addAsChild($item)
    {
        if ($this->selectedItem) {
            ThemeMenuItem::addAsChild($this->menu, array_merge($item, ['source' => $this->getActiveThemeNamespace()]), $this->selectedItem['id']);
            Notification::make()
                    ->title('Menu item added')
                    ->success()
                    ->send();
            $this->menuItems = $this->menu->items()->with('children')->whereNull('parent_id')->orderBy('order')->get();
        }
    }

    public function updateMenuItemOrder($itemId, $position)
    {
        $menuItem = ThemeMenuItem::find($itemId);
        
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
        return ThemeMenuItem::find($this->selectedItem['id']);
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
                ThemeMenuItem::reorderSiblings($this->menu, $order, $parent);
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