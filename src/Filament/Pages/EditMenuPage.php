<?php

namespace Raakkan\OnlyLaravel\Filament\Pages;

use Livewire\Attributes\On;
use Filament\Resources\Pages\Page;
use Raakkan\OnlyLaravel\Filament\Resources\MenuResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;

class EditMenuPage extends Page
{
    use InteractsWithRecord;
    protected static string $resource = MenuResource::class;
    
    protected static string $view = 'only-laravel::filament.pages.menu-page';

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    public function getTitle(): string
    {
        return 'Edit Menu';
    }
}