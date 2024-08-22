<?php

namespace Raakkan\OnlyLaravel\Template\Livewire;

use Livewire\Component;
use Filament\Forms\Form;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Raakkan\OnlyLaravel\Models\TemplateModel;
use Filament\Forms\Concerns\InteractsWithForms;
use Raakkan\OnlyLaravel\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Models\TemplateBlockModel;

class BlockSettings extends Component implements HasForms
{
    use InteractsWithForms;
    
    public TemplateBlockModel $blockModel;
    public TemplateModel $templateModel;
    public ?array $settings = [];
    public $type = 'settings';

    public function mount()
    {
        $this->form->fill($this->getModel()->settings ?? []);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getSettingFields())->statePath('settings');
    }

    public function save()
    {
        $onlylaravel = [];
        if (array_key_exists('only-laravel', $this->getModel()->settings)) {
            $onlylaravel = $this->getModel()->settings['only-laravel'];
        }
        $settings = array_merge($onlylaravel, $this->form->getState());
        
        $this->getModel()->settings['only-laravel'] = $settings;
        $this->getModel()->save();

        Notification::make()
            ->title('Settings saved')
            ->success()
            ->send();

        $this->dispatch('settings-saved', id: isset($this->templateModel) ? $this->templateModel->id : $this->blockModel->id);
    }

    public function getModel()
    {
        return isset($this->templateModel) ? $this->templateModel : $this->blockModel;
    }

    public function getSettingFields()
    {
        if (isset($this->templateModel)) {
            $fields = match ($this->type) {
                'settings' => $this->getTemplate()->getSettingFields(),
                'text' => $this->getTemplate()->getTextSettingFields(),
                'width' => $this->getTemplate()->getWidthSettingFields(),
                'height' => $this->getTemplate()->getHeightSettingFields(),
                'spacing' => $this->getTemplate()->getSpacingSettingFields(),
                'max-width' => $this->getTemplate()->getMaxWidthSettingFields(),
                'color' => $this->getTemplate()->getColorSettingFields(),
            };

            return $fields;
        } else {
            $fields = match ($this->type) {
                'settings' => $this->getBlock()->getSettingFields(),
                'text' => $this->getBlock()->getTextSettingFields(),
                'width' => $this->getBlock()->getWidthSettingFields(),
                'height' => $this->getBlock()->getHeightSettingFields(),
                'spacing' => $this->getBlock()->getSpacingSettingFields(),
                'max-width' => $this->getBlock()->getMaxWidthSettingFields(),
                'color' => $this->getBlock()->getColorSettingFields(),
            };

            return $fields;
        }
    }
    
    public function getBlock()
    {
        $block = TemplateManager::getBlockByName($this->blockModel->name)->setModel($this->blockModel);

        return $block;
    }

    public function getTemplate()
    {
        return TemplateManager::getTemplate($this->templateModel->name)->setModel($this->templateModel);
    }
    
    public function render()
    {
        return view('only-laravel::template.livewire.block-settings');
    }
}
