<?php

namespace  Raakkan\OnlyLaravel\Providers;

use Livewire\Livewire;
use Raakkan\PhpTailwind\PhpTailwind;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\AliasLoader;
use Raakkan\OnlyLaravel\Css\CssParser;
use Illuminate\Support\ServiceProvider;
use Raakkan\OnlyLaravel\Menu\MenuManager;
use Raakkan\OnlyLaravel\Page\PageManager;
use Raakkan\OnlyLaravel\OnlyLaravelManager;
use Filament\Forms\Components\BaseFileUpload;
use Raakkan\OnlyLaravel\Plugin\PluginManager;
use Raakkan\OnlyLaravel\Template\FontManager;
use Raakkan\OnlyLaravel\Template\TemplateManager;
use Raakkan\OnlyLaravel\Filament\Components\BaseFileUpload as CustomBaseFileUpload;

class OnlyLaravelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        dd(PhpTailwind::make('p-0 pr-px p-0.5 px-1 px-1 py-1 ps-2 pe-2 pt-2 pb-2 pr-2 pl-2 po-3 m-0 mx-1 my-1 ms-2 me-2 mt-2 mb-2 mr-2 ml-2 mo-3 space-x-1 space-y-1 space-x-2 space-y-2')
        ->compress()->toString());
        AliasLoader::getInstance()->alias(BaseFileUpload::class, CustomBaseFileUpload::class);
        
        $this->loadViewsFrom($this->getPath('resources/views'), 'only-laravel');
        $this->registerLivewireComponents();
        app('plugin-manager')->bootActivatedPlugins();
    }

    public function register(): void
    {
        $this->registerConfigs();

        $this->app->singleton('only-laravel', function () {
            return new OnlyLaravelManager();
        });

        $this->app->singleton('page-manager', function () {
            return new PageManager();
        });

        $this->app->singleton('menu-manager', function () {
            return new MenuManager();
        });

        $this->app->singleton('template-manager', function () {
            return new TemplateManager();
        });

        $this->app->singleton('font-manager', function () {
            return new FontManager();
        });

        $this->app->singleton('plugin-manager', function () {
            return new PluginManager(app('only-laravel'), app('page-manager'), app('menu-manager'), app('template-manager'), app('font-manager'));
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