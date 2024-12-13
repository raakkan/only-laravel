<?php

namespace Raakkan\OnlyLaravel\Installer\Steps;

use Illuminate\View\View;
use Raakkan\OnlyLaravel\Plugin\PluginManager;

class PluginsStep extends Step
{
    public function init() {}

    public static function make(): self
    {
        return new self;
    }

    public function validate(): bool
    {
        return true;
    }

    public function getTitle(): string
    {
        return 'Step 5: Configure Plugins';
    }

    public function render(): View
    {
        $pluginManager = app(PluginManager::class);
        $pluginManager->updateOrCreatePlugins();

        return view('only-laravel::installer.steps.plugins', [
            'step' => $this,
            'plugins' => $pluginManager->getAllPlugins(),
        ]);
    }
}
