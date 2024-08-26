<?php

namespace Raakkan\OnlyLaravel\Template\Livewire;

use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Raakkan\OnlyLaravel\Models\TemplateModel;
use Filament\Forms\Concerns\InteractsWithForms;
use Raakkan\OnlyLaravel\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Template\PageTemplate;

class TemplateSettingsComponent extends Component implements HasForms
{
    use InteractsWithForms;
    
    public TemplateModel $template;
    public ?array $settings = [];

    public function mount()
    {
        $this->form->fill($this->template->settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getTemplate()->getSettingFields())
            ->statePath('settings');
    }

    public function save()
    {
        $settings = array_replace_recursive($this->template->settings ?? [], $this->form->getState());
        $this->template->update([
            'settings' => $settings,
        ]);

        Notification::make()
            ->title('Template settings saved')
            ->success()
            ->send();
    }

    public function getTemplate()
    {
        return PageTemplate::make($this->template->name)->setModel($this->template);
    }
    
    public function render()
    {
        return view('only-laravel::template.livewire.template-settings');
    }
}