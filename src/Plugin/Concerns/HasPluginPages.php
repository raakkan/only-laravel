<?php

namespace Raakkan\OnlyLaravel\Plugin\Concerns;

trait HasPluginPages
{
    public function getPages(): array
    {
        $pluginClass = $this->getPluginClass();

        return $pluginClass->getPages();
    }

    public function createPages()
    {
        $pluginClass = $this->getPluginClass();
        $pages = $pluginClass->getPages();

        foreach ($pages as $page) {
            $page->create();
        }
    }
}