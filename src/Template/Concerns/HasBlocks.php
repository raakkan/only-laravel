<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

use Raakkan\OnlyLaravel\Template\Blocks\Block;

trait HasBlocks
{
    protected $blocks = [];
    
    public function blocks($blocks)
    {
        $this->blocks = $blocks;
        return $this;
    }

    public function addBlock(Block $block)
    {
        $this->blocks[] = $block;
        return $this;
    }

    public function getBlocks()
    {
        return $this->blocks;
    }

    public function getBlock($name)
    {
        foreach ($this->blocks as $block) {
            if ($block->getName() == $name) {
                return $block;
            }
        }
    }

    public function getBlockViews()
    {
        return collect($this->blocks)->flatMap(function ($block) {
            return $this->getBlockViewsRecursive($block);
        })->filter()->unique()->values()->all();
    }

    protected function getBlockViewsRecursive($block)
    {
        if ($block->getType() == 'component') {
            $views = [$block->getActiveDesignVariantView() ?? $block->getView()];
        } else {
            $views = [$block->getView()];
        }

        if (method_exists($block, 'getChildren')) {
            foreach ($block->getChildren() as $childBlock) {
                $views = array_merge($views, $this->getBlockViewsRecursive($childBlock));
            }
        }

        return $views;
    }

    public function getCssClassesFromBlocks()
    {
        return collect($this->blocks)->flatMap(function ($block) {
            return $this->getCssClassesFromBlocksRecursive($block);
        })->filter()->unique()->values()->all();
    }

    protected function getCssClassesFromBlocksRecursive($block)
    {
        $classes = [];

        // Render the block and extract CSS classes
        $renderedHtml = $this->renderBlock($block);
        $classes = array_merge($classes, $this->extractCssClassesFromHtml($renderedHtml));

        // If the block has children, recursively get classes from them
        if (method_exists($block, 'getChildren')) {
            foreach ($block->getChildren() as $childBlock) {
                $classes = array_merge($classes, $this->getCssClassesFromBlocksRecursive($childBlock));
            }
        }

        return $classes;
    }

    protected function renderBlock($block)
    {
        // Assuming the block has a render method. Adjust if necessary.
        return $block->render();
    }

    protected function extractCssClassesFromHtml($html)
    {
        preg_match_all('/class="([^"]+)"/', $html, $matches);
        $classString = implode(' ', $matches[1]);
        return array_unique(explode(' ', $classString));
    }

    protected function getCssClassesFromFile($file)
    {
        $content = file_get_contents($file);
        preg_match_all('/class="([^"]+)"/', $content, $matches);
        return $matches[1];
    }
}