<?php

namespace Raakkan\OnlyLaravel\Filament;

use Filament\Panel;
use Filament\Contracts\Plugin;
use Filament\Navigation\NavigationGroup;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;
use Raakkan\OnlyLaravel\Filament\Resources\MenuResource;
use Raakkan\OnlyLaravel\Filament\Resources\PageResource;
use Raakkan\OnlyLaravel\Plugin\Filament\Pages\PluginsPage;
use Raakkan\OnlyLaravel\Filament\Resources\TemplateResource;
use Raakkan\OnlyLaravel\Setting\Filament\Pages\AiSettingsPage;
use Raakkan\OnlyLaravel\Setting\Filament\Pages\GlobalPageInsertPage;

class OnlyLaravelPlugin implements Plugin
{
    use Makable;
    
    protected $pages = [
        PluginsPage::class,
        AiSettingsPage::class,
        GlobalPageInsertPage::class,
    ];
    protected $resources = [
        TemplateResource::class,
        MenuResource::class,
        PageResource::class,
    ];

    public function getId(): string
    {
        return 'only-laravel';
    }
    public function register(Panel $panel): void
    {
        $resources = app('only-laravel')->getFilamentResources();
        $pages = app('only-laravel')->getFilamentPages();
        $navigationGroups = app('only-laravel')->getFilamentNavigationGroups();
        
        $panel->pages(array_merge($this->pages, $pages))->resources(array_merge($this->resources, $resources))->navigationGroups(array_merge([
            NavigationGroup::make()
                 ->label('Appearance')
                 ->icon('heroicon-o-paint-brush'),
            NavigationGroup::make()
                 ->label('Settings')
                 ->icon('heroicon-o-cog'),
        ], $navigationGroups));
    }
    public function boot(Panel $panel): void
    {
        //
    }
}