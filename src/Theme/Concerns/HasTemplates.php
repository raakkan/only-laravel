<?php

namespace Raakkan\OnlyLaravel\Theme\Concerns;

use Raakkan\OnlyLaravel\Theme\Template\Blocks\Block;
use Raakkan\OnlyLaravel\Theme\Template\Blocks\Components\BlockComponent;
use Raakkan\OnlyLaravel\Theme\Template\Template;

trait HasTemplates
{
    public function getTemplates(): array
    {
        if ($this->hasThemeClass()) {
            return collect($this->themeClass::getTemplates())->filter(function ($item){
                return $item instanceof Template;
            })->each(function ($template) {
                $template->setSource($this->getNamespace());
            })->all();
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
            return collect($this->themeClass::getBlockComponents())->filter(function ($item){
                return $item instanceof BlockComponent;
            })->each(function ($component) {
                $component->setSource($this->getNamespace());
            })->all();
        }

        return [];
    }

    public function getBlocks(): array
    {
        if ($this->hasThemeClass()) {
            return collect($this->themeClass::getBlocks())->filter(function ($item){
                return $item instanceof Block;
            })->each(function ($block) {
                $block->setSource($this->getNamespace());
            })->all();
        }

        return [];
    }
}