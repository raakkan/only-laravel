<?php

namespace Raakkan\OnlyLaravel\Plugin\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Raakkan\OnlyLaravel\Plugin\Models\PluginModel;
use Raakkan\OnlyLaravel\Plugin\Facades\PluginManager;

class PluginsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';
    protected static string $view = 'only-laravel::filament.pages.plugins';
    protected static ?string $title = 'Plugins';
    protected static ?string $navigationTitle = 'Plugins';

    public function mount(): void
    {
    }

    public function getPlugins(): array
    {
        $plugins = PluginManager::loadPlugins();
        return collect($plugins)->map(function ($plugin) {
            $plugin->setActivated(PluginManager::pluginIsActivated($plugin->getName()));
            return $plugin;
        })->toArray();
    }

    public function activatePlugin(string $name): void
    {
        $plugin = collect($this->getPlugins())->first(function ($plugin) use ($name) {
            return $plugin->getName() === $name;
        });
        $plugin->register();
        $plugin->migrate();
        $plugin->createPages();
        $plugin->createTemplates();
        PluginManager::activatePlugin($name);
    }

    public function deactivatePlugin(string $name): void
    {
        PluginManager::deactivatePlugin($name);
    }

    public function getTitle(): string
    {
        return __('Manage Plugins');
    }
}
