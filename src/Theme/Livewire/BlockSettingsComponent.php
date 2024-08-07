<?php

namespace Raakkan\OnlyLaravel\Theme\Livewire;

use Livewire\Component;
use Filament\Forms\Form;
use Livewire\Attributes\Reactive;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use Raakkan\OnlyLaravel\Theme\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Theme\Models\ThemeTemplateBlock;

class BlockSettingsComponent extends Component implements HasForms
{
    use InteractsWithForms;
    
    #[Reactive] 
    public ThemeTemplateBlock $block;
    public ?array $settings = [];

    public function mount()
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getBlockSettings())
            ->statePath('settings');
    }

    public function save()
    {
        $block = ThemeTemplateBlock::find($this->block->id);
        $block->update([
            'settings' => $this->form->getState(),
        ]);

        Notification::make()
            ->title('Block settings saved')
            ->success()
            ->send();
    }

    public function getBlockSettings()
    {
        return $this->getBlock()->getSettings();
    }
    
    public function getBlock()
    {
        if ($this->block->type == 'block') {
            $block = TemplateManager::getBlockByName($this->block->name)->setModel($this->block);
        } else {
            $block = TemplateManager::getComponentByName($this->block->name)->setModel($this->block);
        }

        return $block;
    }
    public function render()
    {
        return view('only-laravel::theme.livewire.block-settings-component');
    }
}