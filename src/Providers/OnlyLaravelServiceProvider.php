<?php

namespace  Raakkan\OnlyLaravel\Providers;

use Livewire\Livewire;
use Illuminate\Support\ServiceProvider;
use Raakkan\OnlyLaravel\OnlyLaravelManager;
use Raakkan\OnlyLaravel\Template\TemplateManager;

class OnlyLaravelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom($this->getPath('resources/views'), 'only-laravel');
        $this->registerLivewireComponents();
    }

    public function register(): void
    {
        $this->registerConfigs();

        $this->app->singleton('only-laravel', function () {
            return new OnlyLaravelManager();
        });

        $this->app->singleton('template-manager', function () {
            return new TemplateManager();
        });
    }

    protected function getPath(string $path = '')
    {
        $rc = new \ReflectionClass(static::class);

        return dirname($rc->getFileName()) . '/../../' . $path;
    }

    protected function registerConfigs(): void
    {
        $configPath = $this->getPath('config');

        $this->mergeConfigFrom(
            "{$configPath}/themes.php",
            'only-laravel::themes'
        );
    }

    public function registerLivewireComponents(): void
    {
        Livewire::component('only-laravel::menu.livewire.menu-items-component', \Raakkan\OnlyLaravel\Menu\Livewire\MenuItemsComponent::class);
        Livewire::component('only-laravel::template.livewire.block', \Raakkan\OnlyLaravel\Template\Livewire\LivewireBlock::class);
        Livewire::component('only-laravel::template.livewire.block-items-component', \Raakkan\OnlyLaravel\Template\Livewire\BlockItemsComponent::class);
        Livewire::component('only-laravel::template.livewire.block-settings-component', \Raakkan\OnlyLaravel\Template\Livewire\BlockSettingsComponent::class);
        Livewire::component('only-laravel::template.livewire.block-color-settings', \Raakkan\OnlyLaravel\Template\Livewire\BlockColorSettings::class);
        Livewire::component('only-laravel::template.livewire.block-text-settings', \Raakkan\OnlyLaravel\Template\Livewire\BlockTextSettings::class);
    }
}