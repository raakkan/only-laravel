<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

use Raakkan\OnlyLaravel\Facades\TemplateManager;

trait HasBlockBuilding
{
    public function makeBlocks($templateBlocks, $blocks)
    {
        $builtBlocks = [];

        foreach ($templateBlocks as $templateBlock) {
            $themeBlock = TemplateManager::getBlockByName($templateBlock->name);
            $templateBlockChildren = $blocks->where('parent_id', $templateBlock->id)->sortBy('order');
            $themeBlock = $this->buildBlockTree($themeBlock, $templateBlockChildren, $blocks);
            $block = $themeBlock->setModel($templateBlock)->setPageModel($this->getPageModel());
            $this->registerBlockAssets($block);
            $builtBlocks[] = $block;
        }

        $this->blocks = $builtBlocks;
        return $this;
    }

    private function buildBlockTree($themeBlock, $templateBlockChildren, $blocks)
    {
        $childBlocks = [];

        foreach ($templateBlockChildren as $block) {
            $blockInstance = TemplateManager::getBlockByName($block->name);
            $blockChildren = $blocks->where('parent_id', $block->id)->sortBy('order');

            if ($blockChildren->isNotEmpty()) {
                $blockInstance = $this->buildBlockTree($blockInstance, $blockChildren, $blocks);
            }

            $b = $blockInstance->setModel($block)->setPageModel($this->getPageModel());
            $this->registerBlockAssets($b);
            $childBlocks[] = $b;
        }

        $themeBlock->children($childBlocks);
        return $themeBlock;
    }
}
