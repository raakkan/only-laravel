<?php

namespace Raakkan\OnlyLaravel\Template\Livewire;

use Livewire\Component;
use Filament\Forms\Form;
use Illuminate\Support\Str;
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

        $this->getModel()->getPageTemplate()->buildCss();
        
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
           return $this->getFieldsByType($this->getTemplate(), $this->type);
        } else {
            return $this->getFieldsByType($this->getBlock(), $this->type);
        }
    }

    public function getFieldsByType($component, $type)
    {
        if ($type == 'settings') {
            $methodName = 'getSettingFields';
        }else{
            $methodName = 'get' . Str::studly($type) . 'SettingFields';
        }
        
        if (method_exists($component, $methodName)) {
            return $component->{$methodName}();
        }

        return [];
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
