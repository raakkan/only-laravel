<?php

namespace Raakkan\OnlyLaravel\Theme\Livewire;

use Livewire\Component;
use Filament\Actions\Action;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\ActionSize;
use Filament\Notifications\Notification;
use Filament\Actions\Contracts\HasActions;
use Raakkan\OnlyLaravel\Models\TemplateModel;
use Filament\Forms\Concerns\InteractsWithForms;
use Raakkan\OnlyLaravel\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Models\TemplateBlockModel;
use Filament\Actions\Concerns\InteractsWithActions;

class LivewireBlock extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;
    public TemplateBlockModel $block;
    public TemplateModel $template;

    public function mount()
    {
        // $this->getBlockComponents();
        if($this->block->name == 'navigation') {
            $block = $this->getBlock();
            $block->storeDefaultSettingsToDatabase();
        }
    }

    public function getBlock()
    {
        if (!$this->block->name) {
           return null;
        }

        $block = TemplateManager::getBlockByName($this->block->name)->setModel($this->block)->setTemplateModel($this->template);
        
        if ($block->getType() == 'block') {
            $block->components($this->getBlockComponents());
        }

        return $block;
    }

    public function getBlockComponents()
    {
        $components = $this->block->children ?? [];
        
        $blockComponents = [];
        foreach ($components as $component) {
            $blockComponents[] = TemplateManager::getBlockByName($component->name)->setModel($component)->setTemplateModel($this->template);
        }
        
        return $blockComponents;
    }

    public function updateBlockOrder($blockId, $position)
    {
        $block = TemplateBlockModel::find($blockId);
        $block->updateOrder($position);
    }

    public function handleDrop(array $data, $location)
    {
        $childCount = $this->template->blocks()->where('parent_id', $this->block->id)->where('location', $location)->count();

        $blockModel = $this->template->blocks()->create([
            'name' => $data['name'],
            'template_id' => $this->template->id,
            'source' => $data['source'],
            'order' => $childCount === 0 ? 0 : $childCount++,
            'location' => $location,
            'type' => $data['type'],
            'parent_id' => $this->block->id
        ]);

        $block = TemplateManager::getBlockByName($blockModel->name)->setModel($blockModel);

        $block->storeDefaultSettingsToDatabase();

        Notification::make()
            ->title('Block created')
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
            ->before(function (Component $livewire) {
                $livewire->dispatch('block-going-to-be-deleted');
            })
            ->action(function (Component $livewire) {
                $order = $this->block->order;
                $parentId = $this->block->parent_id;
                $location = $this->block->location;
        
                $this->block->delete();

                $livewire->dispatch('block-deleted');

                TemplateBlockModel::reorderSiblings($this->template, $order, $parentId, $location);
                
                Notification::make()
                    ->title('Block deleted')
                    ->success()
                    ->send();
            });
    }

    public function toggleDisableAction(): Action
    {
        return Action::make('toggleDisable')
            ->requiresConfirmation()
            ->label(fn () => $this->block->disabled ? 'Enable' : 'Disable')
            ->size(ActionSize::Small)
            ->color(fn () => $this->block->disabled ? 'gray' : 'primary')
            ->link()
            ->action(function () {
                $this->block->disabled = !$this->block->disabled;
                $this->block->save();
                
                Notification::make()
                    ->title($this->block->disabled ? 'Block disabled' : 'Block enabled')
                    ->success()
                    ->send();
            });
    }

    public function render()
    {
        return view('only-laravel::theme.livewire.block');
    }
}