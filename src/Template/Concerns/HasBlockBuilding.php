<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

use Raakkan\OnlyLaravel\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Template\Blocks\NotFoundBlock;

trait HasBlockBuilding
{
    public function getBlocksWithoutParent()
    {
        $blocks = collect($this->model->blocks)->filter(function ($block) {
            return $block->disabled == 0 && $block->parent_id;
        });

        $builtBlocks = [];

        foreach ($blocks as $templateBlock) {
            $themeBlock = TemplateManager::getBlockByName($templateBlock->name);
            if (! $themeBlock) {
                $themeBlock = NotFoundBlock::make()->setType($templateBlock->type);
            }
            $templateBlockChildren = $blocks->where('parent_id', $templateBlock->id)->sortBy('order');
            $themeBlock = $this->buildBlockTree($themeBlock, $templateBlockChildren, $blocks);
            $block = $themeBlock->setModel($templateBlock)->setPageModel($this->getPageModel())->setTemplateModel($this->getModel());
            $this->registerBlockAssets($block);
            $builtBlocks[] = $block;
        }

        return $builtBlocks;
    }
    
    public function makeBlocks($templateBlocks, $blocks)
    {
        $builtBlocks = [];

        foreach ($templateBlocks as $templateBlock) {
            $themeBlock = TemplateManager::getBlockByName($templateBlock->name);
            if (! $themeBlock) {
                $themeBlock = NotFoundBlock::make()->setType($templateBlock->type);
            }
            $templateBlockChildren = $blocks->where('parent_id', $templateBlock->id)->sortBy('order');
            $themeBlock = $this->buildBlockTree($themeBlock, $templateBlockChildren, $blocks);
            $block = $themeBlock->setModel($templateBlock)->setPageModel($this->getPageModel())->setTemplateModel($this->getModel());
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
            if (! $blockInstance) {
                $blockInstance = NotFoundBlock::make()->setType($block->type);
            }
            $blockChildren = $blocks->where('parent_id', $block->id)->sortBy('order');

            if ($blockChildren->isNotEmpty()) {
                $blockInstance = $this->buildBlockTree($blockInstance, $blockChildren, $blocks);
            }

            $b = $blockInstance->setModel($block)->setPageModel($this->getPageModel())->setTemplateModel($this->getModel());
            $this->registerBlockAssets($b);
            $childBlocks[] = $b;
        }

        if ($themeBlock->isType('block')) {
            $themeBlock->children($childBlocks);
        }

        return $themeBlock;
    }
}
