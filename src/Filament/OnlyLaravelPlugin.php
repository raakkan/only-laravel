<?php

namespace Raakkan\OnlyLaravel\Filament;

use Filament\Panel;
use Filament\Contracts\Plugin;
use Filament\Navigation\NavigationGroup;
use Raakkan\OnlyLaravel\Theme\Filament\Pages\ThemesPage;

class OnlyLaravelPlugin implements Plugin
{
    protected $pages = [
        ThemesPage::class,
    ];

    public static function make(): static
    {
        return app(static::class);
    }
    public function getId(): string
    {
        return 'only-laravel';
    }
    public function register(Panel $panel): void
    {
        $panel->pages($this->pages)->navigationGroups([
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