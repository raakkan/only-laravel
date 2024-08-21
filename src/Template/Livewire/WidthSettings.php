<?php

namespace Raakkan\OnlyLaravel\Template\Livewire;

use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Raakkan\OnlyLaravel\Models\TemplateModel;
use Filament\Forms\Concerns\InteractsWithForms;
use Raakkan\OnlyLaravel\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Models\TemplateBlockModel;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasWidthSettings;

class WidthSettings extends Component implements HasForms
{
    use InteractsWithForms;
    use HasWidthSettings;
    
    public TemplateBlockModel $blockModel;
    public TemplateModel $templateModel;
    public ?array $settings = [];

    public function mount()
    {
        $this->form->fill($this->getModel()->settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getWidthSettingFields())->statePath('settings');
    }

    public function save()
    {
        $settings = array_merge($this->getModel()->settings ?? [], $this->form->getState());
        
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

    public function getWidthSettingFields()
    {
        if (isset($this->templateModel)) {
            return $this->getTemplate()->getWidthSettingFields();
        } else {
            return $this->getBlock()->getWidthSettingFields();
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
