<?php

namespace Raakkan\OnlyLaravel\Menu\Livewire;

use Filament\Forms\Components\TextInput;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Raakkan\OnlyLaravel\Models\MenuModel;
use Filament\Actions\Contracts\HasActions;
use Raakkan\OnlyLaravel\Models\MenuItemModel;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;

class MenuItemComponent extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;
    public MenuModel $menu;
    public MenuItemModel $item;
    public ?array $settings = [];

    public function mount()
    {
        $this->form->fill($this->item->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('label')->required(),
                TextInput::make('url')->required()->url(),
            ])
            ->statePath('settings')
            ->model($this->item);
    }

    public function save()
    {
        $this->item->update($this->form->getState());
        Notification::make()
            ->title('Menu item saved')
            ->success()
            ->send();
    }

    public function handleDrop(array $data)
    {
        $itemsCount = $this->menu->items()->where('parent_id', $this->item->id)->count();

        $item = $this->menu->items()->create([
            'name' => $data['name'],
            'order' => $itemsCount === 0 ? 0 : $itemsCount++,
            'url' => $data['url'],
            'icon' => $data['icon'],
            'label' => $data['label'],
            'parent_id' => $this->item->id,
        ]);

        Notification::make()
            ->title('Menu item created')
            ->success()
            ->send();
    }

    public function deleteAction(): Action
    {
        return Action::make('delete')
            ->requiresConfirmation()
            ->icon('heroicon-o-trash')
            ->iconButton()
            ->color('danger')
            ->action(function (Component $livewire) {
                $order = $this->item->order;
                $parentId = $this->item->parent_id;
        
                $this->item->delete();

                $livewire->dispatch('item-deleted');

                MenuItemModel::reorderSiblings($this->menu, $order, $parentId);
                
                Notification::make()
                    ->title('Item deleted')
                    ->success()
                    ->send();
            });
    }

    public function render()
    {
        return view('only-laravel::menu.livewire.menu-item-component');
    }
}