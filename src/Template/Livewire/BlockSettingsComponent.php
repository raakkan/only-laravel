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
    
    public TemplateBlockModel $blockModel;
    public ?array $settings = [];

    public function mount()
    {
        $this->form->fill($this->blockModel->settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getBlockSettings())
            ->statePath('settings');
    }

    public function save()
    {
        $settings = array_merge($this->blockModel->settings ?? [], $this->form->getState());
        $this->blockModel->update([
            'settings' => $settings,
        ]);
        $this->dispatch('block-settings-saved', id: $this->blockModel->id);

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
        $block = TemplateManager::getBlockByName($this->blockModel->name)->setModel($this->blockModel);

        return $block;
    }
    
    public function render()
    {
        return view('only-laravel::template.livewire.block-settings-component');
    }
}