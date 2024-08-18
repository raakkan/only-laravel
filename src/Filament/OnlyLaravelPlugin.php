<?php

namespace Raakkan\OnlyLaravel\Filament;

use Filament\Panel;
use Filament\Contracts\Plugin;
use Filament\Navigation\NavigationGroup;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;
use Raakkan\OnlyLaravel\Filament\Resources\MenuResource;
use Raakkan\OnlyLaravel\Filament\Resources\PageResource;
use Raakkan\OnlyLaravel\Filament\Resources\TemplateResource;

class OnlyLaravelPlugin implements Plugin
{
    use Makable;
    
    protected $pages = [
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
        $panel->pages($this->pages)->resources($this->resources)->navigationGroups([
            NavigationGroup::make()
                 ->label('Appearance')
                 ->icon('heroicon-o-paint-brush'),
        ]);
    }
    public function boot(Panel $panel): void
    {
        //
    }
}