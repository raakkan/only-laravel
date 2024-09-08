<?php

namespace Raakkan\OnlyLaravel\Template\Livewire;

use Livewire\Component;
use Filament\Forms\Form;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Reactive;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Raakkan\OnlyLaravel\Models\TemplateModel;
use Raakkan\OnlyLaravel\Template\PageTemplate;
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
        if (isset($this->blockModel) && !$this->blockModel->name) {
            return $form;
         }
        return $form
            ->schema($this->getSettingFields())->statePath('settings');
    }

    public function save()
    {
        
        $settings = array_replace_recursive($this->getModel()->settings ?? [], $this->form->getState());
        
        $this->getModel()->settings = $settings;
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
                'padding' => $this->getTemplate()->getPaddingSettingFields(),
                'width' => $this->getTemplate()->getWidthSettingFields(),
                'background' => $this->getTemplate()->getBackgroundSettingFields(),
                'customstyle' => $this->getTemplate()->getCustomStyleSettingFields(),
            };

            return $fields;
        } else {
            $fields = match ($this->type) {
                'settings' => $this->getBlock()->getSettingFields(),
                'width' => $this->getBlock()->getWidthSettingFields(),
                'border' => $this->getBlock()->getBorderSettingFields(),
                'padding' => $this->getBlock()->getPaddingSettingFields(),
                'margin' => $this->getBlock()->getMarginSettingFields(),
                'background' => $this->getBlock()->getBackgroundSettingFields(),
                'customstyle' => $this->getBlock()->getCustomStyleSettingFields(),
                'customattribute' => $this->getBlock()->getCustomAttributeSettingFields(),
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
        return PageTemplate::make($this->templateModel->name)->setModel($this->templateModel);
    }
    
    public function render()
    {
        return view('only-laravel::template.livewire.block-settings');
    }
}
