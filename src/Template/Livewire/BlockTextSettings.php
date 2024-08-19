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

class BlockTextSettings extends Component implements HasForms
{
    use InteractsWithForms;
    
    public TemplateBlockModel $blockModel;
    public ?string $fontFamily = null;
    public ?string $fontSize = null;
    public ?string $fontWeight = null;
    public ?string $fontStyle = 'normal';
    public ?string $letterSpacing = null;
    public ?string $lineHeight = null;

    public function mount()
    {
        $this->form->fill([
            'fontFamily' => $this->blockModel->settings['text']['font']['family'] ?? null,
            'fontSize' => $this->blockModel->settings['text']['font']['size'] ?? null,
            'fontWeight' => $this->blockModel->settings['text']['font']['weight'] ?? null,
            'fontStyle' => $this->blockModel->settings['text']['font']['style'] ?? 'normal',
            'letterSpacing' => $this->blockModel->settings['text']['font']['letterSpacing'] ?? null,
            'lineHeight' => $this->blockModel->settings['text']['font']['lineHeight'] ?? null,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getTextSettingFields());
    }

    public function updated($property)
    {
        $settings = $this->blockModel->settings;
        
        if ($property == 'fontFamily') {
            $settings['text']['font']['family'] = $this->fontFamily;
        }

        if ($property == 'fontSize') {
            $settings['text']['font']['size'] = $this->fontSize;
        }

        if ($property == 'fontWeight') {
            $settings['text']['font']['weight'] = $this->fontWeight;
        }

        if ($property == 'fontStyle') {
            $settings['text']['font']['style'] = $this->fontStyle;
        }

        if ($property == 'letterSpacing') {
            $settings['text']['font']['letterSpacing'] = $this->letterSpacing;
        }

        if ($property == 'lineHeight') {
            $settings['text']['font']['lineHeight'] = $this->lineHeight;
        }

        $this->blockModel->update([
            'settings' => $settings,
        ]);

        $this->dispatch('block-settings-saved', id: $this->blockModel->id);
    }

    public function getTextSettingFields()
    {
        return $this->getBlock()->getTextSettingFields();
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
