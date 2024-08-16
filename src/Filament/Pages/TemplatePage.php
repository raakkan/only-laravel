<?php

namespace Raakkan\OnlyLaravel\Filament\Pages;

use Filament\Pages\Page;
use Livewire\Attributes\On;
use Raakkan\OnlyLaravel\Models\TemplateModel;

class TemplatePage extends Page
{
    protected static string $view = 'only-laravel::theme.filament.pages.template-page';

    protected static ?string $navigationGroup = 'Appearance';
    protected static ?string $slug = 'appearance/templates';
    public $template;
    public $selectedBlock;

    #[On('block-deleted')] 
    public function blockDeleted()
    {
        $this->template->refresh();
    }

    public function mount()
    {
        $this->template = TemplateModel::first();
    }

    public function showBlockSettings($blockId)
    {
        $this->selectedBlock = $blockId;
    }

    public function getTitle(): string
    {
        return 'Templates';
    }

    public static function getNavigationLabel(): string
    {
        return 'Templates';
    }
}