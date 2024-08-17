<?php

namespace Raakkan\OnlyLaravel\Template\Livewire;

use Livewire\Component;
use Filament\Forms\Form;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use Raakkan\OnlyLaravel\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Models\TemplateBlockModel;

class BlockColorSettings extends Component implements HasForms
{
    use InteractsWithForms;
    
    public TemplateBlockModel $blockModel;
    public ?string $backgroundColor = null;
    public ?string $backgroundImage = null;
    public ?string $textColor = null;

    public function mount()
    {
        $this->form->fill([
            'backgroundColor' => $this->blockModel->settings['color']['background']['color'] ?? null,
            'backgroundImage' => $this->blockModel->settings['color']['background']['image'] ?? null,
            'textColor' => $this->blockModel->settings['color']['text']['color'] ?? null,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getColorSettingFields());
    }

    public function updated($property)
    {
        if ($property == 'backgroundColor') {
            $settings = $this->blockModel->settings;
            $settings['color']['background']['color'] = $this->backgroundColor;
        }

        if ($property == 'backgroundImage') {
            $settings = $this->blockModel->settings;
            $settings['color']['background']['image'] = $this->backgroundImage;
        }

        if ($property == 'textColor') {
            $settings = $this->blockModel->settings;
            $settings['color']['text']['color'] = $this->textColor;
        }

        $this->blockModel->update([
            'settings' => $settings,
        ]);

        $this->dispatch('block-settings-saved', id: $this->blockModel->id);
    }

    public function getColorSettingFields()
    {
        return $this->getBlock()->getColorSettingFields();
    }
    
    public function getBlock()
    {
        $block = TemplateManager::getBlockByName($this->blockModel->name)->setModel($this->blockModel);

        return $block;
    }
    
    public function render()
    {
        return view('only-laravel::template.livewire.block-settings');
    }
}