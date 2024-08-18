<?php

namespace Raakkan\OnlyLaravel\Template\Livewire;

use Livewire\Component;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Raakkan\OnlyLaravel\Models\TemplateModel;
use Filament\Forms\Concerns\InteractsWithForms;
use Raakkan\OnlyLaravel\Facades\TemplateManager;

class TemplateSettingsComponent extends Component implements HasForms
{
    use InteractsWithForms;
    
    public TemplateModel $template;
    public ?array $settings = [];
    public ?array $maxWidthSettings = [];
    public ?array $colorSettings = [];
    public ?array $textSettings = [];
    public ?array $spacingSettings = [];

    public function mount()
    {
        $this->settingsForm->fill($this->template->settings);
        $this->maxWidthForm->fill($this->template->settings);
        $this->colorForm->fill($this->template->settings);
        $this->textForm->fill($this->template->settings);
        $this->spacingForm->fill($this->template->settings);
    }

    public function settingsForm(Form $form): Form
    {
        return $form
            ->schema($this->getTemplate()->getSettingFields())
            ->statePath('settings');
    }

    public function maxWidthForm(Form $form): Form
    {
        return $form
            ->schema($this->getTemplate()->getMaxWidthSettingFields())
            ->statePath('maxWidthSettings');
    }

    public function colorForm(Form $form): Form
    {
        return $form
            ->schema($this->getTemplate()->getColorSettingFields())
            ->statePath('colorSettings');
    }

    public function textForm(Form $form): Form
    {
        return $form
            ->schema($this->getTemplate()->getTextSettingFields())
            ->statePath('textSettings');
    }

    public function spacingForm(Form $form): Form
    {
        return $form
            ->schema($this->getTemplate()->getSpaceSettingFields())
            ->statePath('spacingSettings');
    }

    public function save($form)
    {
        $settings = array_merge($this->template->settings ?? [], $this->{$form}->getState());
        $this->template->update([
            'settings' => $settings,
        ]);

        Notification::make()
            ->title('Template settings saved')
            ->success()
            ->send();
    }

    protected function getForms(): array
    {
        return [
            'settingsForm',
            'maxWidthForm',
            'colorForm',
            'textForm',
            'spacingForm',
        ];
    }

    public function getTemplate()
    {
        return TemplateManager::getTemplate($this->template->name)->setModel($this->template);
    }
    
    public function render()
    {
        return view('only-laravel::template.livewire.template-settings');
    }
}