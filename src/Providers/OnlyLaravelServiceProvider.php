<?php

namespace  Raakkan\OnlyLaravel\Providers;

use Livewire\Livewire;
use Illuminate\Support\ServiceProvider;
use Raakkan\OnlyLaravel\Theme\ThemesManager;
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

        $this->app->singleton('themes-manager', function () {
            return new ThemesManager();
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
        Livewire::component('only-laravel::theme.livewire.menu-item-manage', \Raakkan\OnlyLaravel\Template\Livewire\MenuItemManage::class);
        Livewire::component('only-laravel::theme.livewire.block', \Raakkan\OnlyLaravel\Template\Livewire\LivewireBlock::class);
        Livewire::component('only-laravel::theme.livewire.block-items-component', \Raakkan\OnlyLaravel\Template\Livewire\BlockItemsComponent::class);
        Livewire::component('only-laravel::theme.livewire.block-settings-component', \Raakkan\OnlyLaravel\Template\Livewire\BlockSettingsComponent::class);
    }
}