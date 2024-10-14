<?php

namespace  Raakkan\OnlyLaravel\Providers;

use Livewire\Livewire;
use Illuminate\Support\ServiceProvider;
use Raakkan\OnlyLaravel\Menu\MenuManager;
use Raakkan\OnlyLaravel\Page\PageManager;
use Raakkan\OnlyLaravel\OnlyLaravelManager;
use Filament\Forms\Components\BaseFileUpload;
use Raakkan\OnlyLaravel\Plugin\PluginManager;
use Raakkan\OnlyLaravel\Template\FontManager;
use Raakkan\OnlyLaravel\Installer\InstallManager;
use Raakkan\OnlyLaravel\Template\TemplateManager;
use Raakkan\OnlyLaravel\Filament\Components\BaseFileUpload as CustomBaseFileUpload;

class OnlyLaravelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadRoutesFrom($this->getPath('routes/web.php'));
        $this->loadViewsFrom($this->getPath('resources/views'), 'only-laravel');
        $this->registerLivewireComponents();
        app('plugin-manager')->bootActivatedPlugins();
        app('page-manager')->registerPageRoutes();
        Livewire::component('only-laravel::installer.livewire.installer', \Raakkan\OnlyLaravel\Installer\Livewire\Installer::class);
    }

    public function register(): void
    {
        $this->registerConfigs();

        $this->app->singleton('only-laravel', function () {
            return new OnlyLaravelManager();
        });

        $this->app->singleton('install-manager', function () {
            return new InstallManager();
        });

        $this->app->singleton('page-manager', function () {
            return new PageManager($this->app);
        });

        $this->app->singleton('menu-manager', function () {
            return new MenuManager();
        });

        $this->app->singleton('template-manager', function () {
            return new TemplateManager();
        });

        $this->app->singleton('plugin-manager', function () {
            return new PluginManager(app('only-laravel'), app('page-manager'), app('menu-manager'), app('template-manager'));
        });

        app('only-laravel')->loadSettingsPagesFromApp();
        app('plugin-manager')->registerActivatedPlugins();
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
        Livewire::component('only-laravel::menu.livewire.menu-items-manage', \Raakkan\OnlyLaravel\Menu\Livewire\MenuItemsManage::class);
        Livewire::component('only-laravel::menu.livewire.menu-item-component', \Raakkan\OnlyLaravel\Menu\Livewire\MenuItemComponent::class);
        Livewire::component('only-laravel::template.livewire.template-settings', \Raakkan\OnlyLaravel\Template\Livewire\TemplateSettingsComponent::class);
        Livewire::component('only-laravel::template.livewire.block', \Raakkan\OnlyLaravel\Template\Livewire\LivewireBlock::class);
        Livewire::component('only-laravel::template.livewire.block-items-component', \Raakkan\OnlyLaravel\Template\Livewire\BlockItemsComponent::class);
        Livewire::component('only-laravel::template.livewire.block-settings', \Raakkan\OnlyLaravel\Template\Livewire\BlockSettings::class);
    }
}