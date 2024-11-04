<?php

namespace Raakkan\OnlyLaravel\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Raakkan\OnlyLaravel\Installer\InstallManager;
use Raakkan\OnlyLaravel\Menu\MenuManager;
use Raakkan\OnlyLaravel\OnlyLaravelManager;
use Raakkan\OnlyLaravel\Page\PageManager;
use Raakkan\OnlyLaravel\Plugin\PluginManager;
use Raakkan\OnlyLaravel\Template\TemplateManager;
use Raakkan\OnlyLaravel\Theme\ThemeManager;
use Raakkan\OnlyLaravel\UI\Components\UI;

class OnlyLaravelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        app('theme-manager')->registerActiveThemeViews();
        UI::registerUiComponents();
        $this->loadRoutesFrom($this->getPath('routes/web.php'));
        $this->loadViewsFrom($this->getPath('resources/views'), 'only-laravel');
        // app('plugin-manager')->bootActivatedPlugins();
        app('page-manager')->registerPageRoutes();
        Livewire::component('only-laravel::installer.livewire.installer', \Raakkan\OnlyLaravel\Installer\Livewire\Installer::class);
    }

    public function register(): void
    {
        $this->registerConfigs();

        $this->app->singleton('only-laravel', function () {
            return new OnlyLaravelManager;
        });

        $this->app->singleton('install-manager', function () {
            return new InstallManager;
        });

        $this->app->singleton('page-manager', function () {
            return new PageManager($this->app);
        });

        $this->app->singleton('menu-manager', function () {
            return new MenuManager;
        });

        $this->app->singleton('theme-manager', function () {
            return new ThemeManager;
        });

        $this->app->singleton('template-manager', function () {
            return new TemplateManager;
        });

        $this->app->singleton('plugin-manager', function () {
            return new PluginManager();
        });

        // app('only-laravel')->loadSettingsPagesFromApp();
        // app('plugin-manager')->registerActivatedPlugins();
    }

    protected function getPath(string $path = '')
    {
        $rc = new \ReflectionClass(static::class);

        return dirname($rc->getFileName()).'/../../'.$path;
    }

    protected function registerConfigs(): void
    {
        $configPath = $this->getPath('config');

        $this->mergeConfigFrom(
            "{$configPath}/themes.php",
            'only-laravel::themes'
        );
    }
}
