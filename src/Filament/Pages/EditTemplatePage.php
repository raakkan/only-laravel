<?php

namespace Raakkan\OnlyLaravel\Filament\Pages;

use Filament\Forms\Form;
use Livewire\Attributes\On;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Raakkan\OnlyLaravel\Filament\Resources\TemplateResource;

class EditTemplatePage extends Page
{
    use InteractsWithRecord;
    protected static string $resource = TemplateResource::class;
    
    protected static string $view = 'only-laravel::filament.pages.template-page';

    #[On('block-deleted')] 
    public function blockDeleted()
    {
        dd('block deleted');
        $this->record->refresh();
    }

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    public function getTitle(): string
    {
        return 'Edit Template';
    }
}