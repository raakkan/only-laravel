<?php

namespace Raakkan\OnlyLaravel\Theme\Concerns;

use Raakkan\OnlyLaravel\Theme\Template\Template;
use Raakkan\OnlyLaravel\Theme\Template\Blocks\Block;
use Raakkan\OnlyLaravel\Theme\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Theme\Template\Blocks\BaseBlock;

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

    public function includeCoreBlocks(): bool
    {
        if ($this->hasThemeClass()) {
            return $this->themeClass::includeCoreBlocks();
        }

        return true;
    }

    public function getBlocks(): array
    {
        if ($this->hasThemeClass()) {
            return collect($this->themeClass::getBlocks())->filter(function ($item){
                return $item instanceof BaseBlock;
            })->each(function ($block) {
                $block->setSource($this->getNamespace());
            })->all();
        }

        return [];
    }

    public function registerThemeBlocks()
    {
        if ($this->hasThemeClass()) {
            TemplateManager::registerBlocks($this->getBlocks());
        }
    }
}