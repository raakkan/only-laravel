<?php

namespace Raakkan\OnlyLaravel\Template\Livewire;

use Livewire\Component;
use Raakkan\OnlyLaravel\Template\Models\TemplateModel;
use Raakkan\OnlyLaravel\Template\PageTemplate;

class TemplateSettingsComponent extends Component
{
    public TemplateModel $template;

    public ?array $settings = [];

    public function mount()
    {
        $this->form->fill($this->template->settings);
    }

    public function save()
    {
        $settings = array_replace_recursive($this->template->settings ?? [], $this->form->getState());
        $this->template->update([
            'settings' => $settings,
        ]);

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
