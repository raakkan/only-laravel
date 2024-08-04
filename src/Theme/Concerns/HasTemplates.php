<?php

namespace Raakkan\OnlyLaravel\Theme\Concerns;

trait HasTemplates
{
    public function getTemplates(): array
    {
        if ($this->hasThemeClass()) {
            return $this->themeClass::getTemplates();
        }

        return [];
    }
}