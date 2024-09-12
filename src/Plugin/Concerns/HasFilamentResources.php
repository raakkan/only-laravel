<?php

namespace Raakkan\OnlyLaravel\Plugin\Concerns;

trait HasFilamentResources
{
    public function getFilamentResources()
    {
        return collect($this->plugins)
            ->filter(function ($plugin) {
                return $this->pluginJsonManager->pluginIsActivated($plugin->getName());
            })
            ->map(function ($plugin) {
                return $plugin->getFilamentResources();
            })
            ->flatten()
            ->toArray();
    }

    public function getFilamentPages()
    {
        return collect($this->plugins)
            ->filter(function ($plugin) {
                return $this->pluginJsonManager->pluginIsActivated($plugin->getName());
            })
            ->map(function ($plugin) {
                return $plugin->getFilamentPages();
            })
            ->flatten()
            ->toArray();
    }

    public function getFilamentNavigationGroups()
    {
        return collect($this->plugins)
            ->filter(function ($plugin) {
                return $this->pluginJsonManager->pluginIsActivated($plugin->getName());
            })
            ->map(function ($plugin) {
                return $plugin->getFilamentNavigationGroups();
            })
            ->flatten()
            ->toArray();
    }
}