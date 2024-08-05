<?php

namespace Raakkan\OnlyLaravel\Theme\Template;

use Raakkan\OnlyLaravel\Theme\Facades\ThemesManager;
use Raakkan\OnlyLaravel\Theme\Template\Blocks\GridBlock;
use Raakkan\OnlyLaravel\Theme\Template\Blocks\FooterBlock;
use Raakkan\OnlyLaravel\Theme\Template\Blocks\HeaderBlock;
use Raakkan\OnlyLaravel\Theme\Template\Blocks\Components\BlockComponent;
use Raakkan\OnlyLaravel\Theme\Template\Blocks\Components\ImageBlockComponent;

class TemplateManager
{
    protected $blocks = [];

    protected $blockComponents = [];

    public function getBlocks()
    {
        $blocks = $this->blocks;

        if ($this->getActiveTheme()->includeCoreBlocks()) {
            $blocks = array_merge($this->getCoreBlocks(), $blocks);
        }
        
        return $blocks;
    }

    public function getBlockComponents()
    {
        $blockComponents = $this->blockComponents;
        if ($this->getActiveTheme()->includeCoreBlockComponents()) {
            $blockComponents = array_merge($this->getCoreBlockComponents(), $blockComponents);
        }

        return $blockComponents;
    }

    public function collectThemeBlocksAndComponents()
    {
        $blocks = collect($this->getActiveTheme()->getBlocks())->filter(function ($item){
            return $item instanceof Block;
        })->each(function ($item){
            return $item->setSource($this->getActiveTheme()->getNamespace());
        })->all();

        $this->blocks = $blocks;

        $components = collect($this->getActiveTheme()->getBlockComponents())->filter(function ($item){
            return $item instanceof BlockComponent;
        })->each(function ($item){
            return $item->setSource($this->getActiveTheme()->getNamespace());
        })->all();

        $this->blockComponents = $components;
    }

    public function getBlockByName($name)
    {
        return collect($this->getBlocks())->first(function ($block) use ($name) {
            return $block->getName() == $name;
        });
    }

    public function getCoreBlocks()
    {
        return [
            HeaderBlock::make(),
            FooterBlock::make(),
            GridBlock::make(),
        ];
    }

    public function getCoreBlockComponents()
    {
        return [
            ImageBlockComponent::make(),
        ];
    }

    public function getActiveTheme()
    {
        return ThemesManager::current();
    }
}
