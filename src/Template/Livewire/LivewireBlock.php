<?php

namespace Raakkan\OnlyLaravel\Template\Livewire;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Support\Enums\ActionSize;
use Livewire\Component;
use Raakkan\OnlyLaravel\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Models\TemplateBlockModel;
use Raakkan\OnlyLaravel\Models\TemplateModel;
use Raakkan\OnlyLaravel\Template\Blocks\NotFoundBlock;

class LivewireBlock extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public TemplateBlockModel $block;

    public TemplateModel $template;

    public function mount()
    {
        $ccs = $this->template->getPageTemplate()->buildCss();
        // $css = explode(' ', $ccs);
        // foreach($css as $class) {
        //     if ($class == 'md:w-3/4') {
        //         dd('dd');
        //     }else{
        //         dd($css);
        //     }
        // }
    }

    public function getBlock()
    {
        if (! $this->block->name) {
            return null;
        }

        $block = TemplateManager::getBlockByName($this->block->name);
        if (! $block) {
            $block = NotFoundBlock::make()->setType($this->block->type);
        }
        $block->setModel($this->block)->setTemplateModel($this->template)
            ->setPageModel($this->template->getPageTemplate()->getPageModel());

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
            $block = TemplateManager::getBlockByName($component->name);
            if (! $block) {
                $block = NotFoundBlock::make()->setType($component->type);
            }
            $blockComponents[] = $block
                ->setModel($component)->setTemplateModel($this->template)
                ->setPageModel($this->template->getPageTemplate()->getPageModel());
        }

        return $blockComponents;
    }

    public function updateBlockOrder($blockId, $position)
    {
        $block = TemplateBlockModel::find($blockId);
        $block->updateOrder($position);
    }

    public function handleDrop(array $data, $location, $componentOnly = false)
    {
        $block = TemplateManager::getBlockByName($data['name']);

        if (! $block) {
            Notification::make()
                ->title('Block not found')
                ->warning()
                ->send();
        }

        if ($componentOnly && $block->getType() == 'block') {
            Notification::make()
                ->title('Block not allowed here')
                ->warning()
                ->send();

            return;
        }

        $childCount = $this->template->blocks()->where('parent_id', $this->block->id)->where('location', $location)->count();

        $blockModel = $this->template->blocks()->create([
            'name' => $data['name'],
            'template_id' => $this->template->id,
            'source' => $data['source'],
            'order' => $childCount === 0 ? 0 : $childCount++,
            'location' => $location,
            'type' => $data['type'],
            'parent_id' => $this->block->id,
        ]);

        $block->setModel($blockModel);

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
                $this->block->disabled = ! $this->block->disabled;
                $this->block->save();

                Notification::make()
                    ->title($this->block->disabled ? 'Block disabled' : 'Block enabled')
                    ->success()
                    ->send();
            });
    }

    public function render()
    {
        return view('only-laravel::template.livewire.block');
    }
}
