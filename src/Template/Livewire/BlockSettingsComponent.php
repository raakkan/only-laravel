<?php

namespace Raakkan\OnlyLaravel\Template\Livewire;

use Livewire\Component;
use Filament\Forms\Form;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use Raakkan\OnlyLaravel\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Models\TemplateBlockModel;

class BlockSettingsComponent extends Component implements HasForms
{
    use InteractsWithForms;
    
    #[Reactive] 
    public $blockId;
    public ?array $settings = [];

    public function mount()
    {
        if ($this->blockId && $this->getBlockModel()) {
            $this->form->fill($this->getBlockModel()->settings);
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getBlockSettings())
            ->statePath('settings');
    }

    public function save()
    {
        $block = TemplateBlockModel::find($this->blockId);
        $settings = array_merge($block->settings, $this->form->getState());
        $block->update([
            'settings' => $settings,
        ]);
        $this->dispatch('block-settings-saved', id: $block->id);

        Notification::make()
            ->title('Block settings saved')
            ->success()
            ->send();
    }

    public function getBlockSettings()
    {
        return $this->getBlock()->getSettingFields();
    }
    
    public function getBlock()
    {
        $block = TemplateManager::getBlockByName($this->getBlockModel()->name)->setModel($this->getBlockModel());

        return $block;
    }

    #[Computed]
    public function getBlockModel()
    {
        return TemplateBlockModel::find($this->blockId);
    }
    
    public function render()
    {
        return view('only-laravel::template.livewire.block-settings-component');
    }
}