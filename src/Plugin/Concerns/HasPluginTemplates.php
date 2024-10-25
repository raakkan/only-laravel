<?php

namespace Raakkan\OnlyLaravel\Plugin\Concerns;

use Illuminate\Support\Collection;

trait HasPluginTemplates
{
    public function getTemplates(): Collection
    {
        $pluginClass = $this->getPluginClass();
        $templates = collect($pluginClass->getTemplates())->map(function ($template) {
            return $template->source($this->namespace);
        });

        return $templates;
    }

    public function createTemplates()
    {
        $templates = $this->getTemplates();

        foreach ($templates as $template) {
            $template->create();
        }
    }
}
