<?php

namespace Raakkan\OnlyLaravel\OnlyLaravel\Concerns;

use Raakkan\OnlyLaravel\Facades\Theme;
use Illuminate\Support\Facades\Artisan;
use Raakkan\OnlyLaravel\Theme\ThemeManager;
use Raakkan\OnlyLaravel\Facades\MenuManager;
use Raakkan\OnlyLaravel\Facades\PageManager;
use Raakkan\OnlyLaravel\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Theme\Models\ThemeModel;
use Raakkan\OnlyLaravel\Plugin\Facades\PluginManager;

trait HasInstall
{
    protected $beforeInstallCallbacks = [];

    protected $afterInstallCallbacks = [];

    public function install()
    {
        $this->runBeforeInstallCallbacks();

        MenuManager::createMenus();
        TemplateManager::createTemplates();
        PageManager::createPages();

        $this->runAfterInstallCallbacks();

        // TODO: cahnge session to db
        Artisan::call('config:clear');
        Artisan::call('storage:link');
    }

    public function beforeInstall($callback)
    {
        if (is_callable($callback)) {
            $this->beforeInstallCallbacks[] = $callback;
        }

        return $this;
    }

    public function afterInstall($callback)
    {
        if (is_callable($callback)) {
            $this->afterInstallCallbacks[] = $callback;
        }

        return $this;
    }

    protected function runBeforeInstallCallbacks()
    {
        foreach ($this->beforeInstallCallbacks as $callback) {
            if (is_callable($callback)) {
                call_user_func($callback, $this);
            }
        }
    }

    protected function runAfterInstallCallbacks()
    {
        foreach ($this->afterInstallCallbacks as $callback) {
            if (is_callable($callback)) {
                call_user_func($callback, $this);
            }
        }
    }
}
