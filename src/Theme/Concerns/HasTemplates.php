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

    public function includeCoreBlockComponents(): bool
    {
        if ($this->hasThemeClass()) {
            return $this->themeClass::includeCoreBlockComponents();
        }

        return true;
    }

    public function includeCoreBlocks(): bool
    {
        if ($this->hasThemeClass()) {
            return $this->themeClass::includeCoreBlocks();
        }

        return true;
    }

    public function getBlockComponents(): array
    {
        if ($this->hasThemeClass()) {
            return $this->themeClass::getBlockComponents();
        }

        return [];
    }

    public function getBlocks(): array
    {
        if ($this->hasThemeClass()) {
            return $this->themeClass::getBlocks();
        }

        return [];
    }
}