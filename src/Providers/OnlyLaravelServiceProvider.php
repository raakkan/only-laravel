<?php

namespace Raakkan\OnlyLaravel\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Raakkan\OnlyLaravel\Installer\InstallManager;
use Raakkan\OnlyLaravel\Installer\Livewire\Installer;
use Raakkan\OnlyLaravel\Menu\MenuManager;
use Raakkan\OnlyLaravel\OnlyLaravelManager;
use Raakkan\OnlyLaravel\Page\PageManager;
use Raakkan\OnlyLaravel\Plugin\PluginManager;
use Raakkan\OnlyLaravel\Support\Sitemap\SitemapGenerator;
use Raakkan\OnlyLaravel\Template\TemplateManager;
use Raakkan\OnlyLaravel\Theme\ThemeManager;
use Raakkan\OnlyLaravel\UI\Components\UI;

class OnlyLaravelServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->isDbConnected()) {
            app('theme-manager')->registerActiveThemeViews();
            app('plugin-manager')->bootActivatedPlugins();
        }

        UI::registerUiComponents();
        $this->loadRoutesFrom($this->getPath('routes/web.php'));
        $this->loadViewsFrom($this->getPath('resources/views'), 'only-laravel');
        app('page-manager')->registerPageRoutes();
        Livewire::component(Installer::class, Installer::class);
    }

    public function isDbConnected(): bool
    {
        try {
            $pdo = DB::connection()->getPdo();

            $themesExist = DB::getSchemaBuilder()->hasTable('themes');
            $pluginsExist = DB::getSchemaBuilder()->hasTable('plugins');

            return $pdo && $themesExist && $pluginsExist;
        } catch (\Exception $e) {
            return false;
        }
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
            return new PluginManager;
        });

        $this->app->singleton('sitemap-generator', function () {
            return new SitemapGenerator;
        });
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
