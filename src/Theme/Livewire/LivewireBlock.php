<?php

namespace Raakkan\OnlyLaravel\Theme\Livewire;

use Livewire\Component;
use Filament\Actions\Action;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Concerns\InteractsWithActions;
use Raakkan\OnlyLaravel\Theme\Models\ThemeTemplate;
use Raakkan\OnlyLaravel\Theme\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Theme\Models\ThemeTemplateBlock;

class LivewireBlock extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;
    public ThemeTemplateBlock $block;
    public ThemeTemplate $template;

    public function mount()
    {
        // $this->getBlockComponents();
    }

    public function getBlock()
    {
        if ($this->block->type == 'block') {
            $block = TemplateManager::getBlockByName($this->block->name)->setModel($this->block);
            $block->components($this->getBlockComponents());
        } else {
            $block = TemplateManager::getComponentByName($this->block->name)->setModel($this->block);
        };

        return $block;
    }

    public function getBlockComponents()
    {
        $components = $this->block->children ?? [];
        
        $blockComponents = [];
        foreach ($components as $component) {
            if ($component->type == 'block') {
                $blockComponents[] = TemplateManager::getBlockByName($component->name)->setModel($component);
            } else {
                $blockComponents[] = TemplateManager::getComponentByName($component->name)->setModel($component);
            }
        }
        
        return $blockComponents;
    }

    public function updateBlockOrder($blockId, $position)
    {
        $block = ThemeTemplateBlock::find($blockId);
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

        if ($blockModel->type == 'block') {
            $block = TemplateManager::getBlockByName($blockModel->name)->setModel($blockModel);
        } else {
            $block = TemplateManager::getComponentByName($blockModel->name)->setModel($blockModel);
        };

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
            ->action(function (Component $livewire) {
                $order = $this->block->order;
                $parentId = $this->block->parent_id;
                $location = $this->block->location;
        
                $this->block->delete();

                $this->dispatch('deleted');

                ThemeTemplateBlock::reorderSiblings($this->template, $order, $parentId, $location);
                
                Notification::make()
                    ->title('Block deleted')
                    ->success()
                    ->send();
            });
    }

    public function render()
    {
        return view('only-laravel::theme.livewire.block');
    }
}