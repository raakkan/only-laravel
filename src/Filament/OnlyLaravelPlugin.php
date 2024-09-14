<?php

namespace Raakkan\OnlyLaravel\Filament;

use Filament\Panel;
use Filament\Contracts\Plugin;
use Filament\Navigation\NavigationGroup;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;
use Raakkan\OnlyLaravel\Filament\Resources\MenuResource;
use Raakkan\OnlyLaravel\Filament\Resources\PageResource;
use Raakkan\OnlyLaravel\Filament\Resources\TemplateResource;
use Raakkan\OnlyLaravel\Plugin\Filament\Pages\PluginsPage;
use Raakkan\OnlyLaravel\Setting\Filament\Pages\AiSettingsPage;
class OnlyLaravelPlugin implements Plugin
{
    use Makable;
    
    protected $pages = [
        PluginsPage::class,
        AiSettingsPage::class,
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
        $settingsPages = app('only-laravel')->getSettingsPages();
        $resources = app('plugin-manager')->getFilamentResources();
        $pages = app('plugin-manager')->getFilamentPages();
        $navigationGroups = app('plugin-manager')->getFilamentNavigationGroups();
        
        $panel->pages(array_merge($this->pages, $settingsPages, $pages))->resources(array_merge($this->resources, $resources))->navigationGroups(array_merge([
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