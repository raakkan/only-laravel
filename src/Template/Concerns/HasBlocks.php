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
        $views = [$block->getView()];

        if (method_exists($block, 'getChildren')) {
            foreach ($block->getChildren() as $childBlock) {
                $views = array_merge($views, $this->getBlockViewsRecursive($childBlock));
            }
        }

        return $views;
    }

    public function getBlockViewPaths()
    {
        return collect($this->blocks)->flatMap(function ($block) {
            return $this->getBlockViewPathsRecursive($block);
        })->filter()->unique()->values()->all();
    }

    protected function getBlockViewPathsRecursive($block)
    {
        $viewPaths = $block->getAllViewPaths();

        if (method_exists($block, 'getChildren')) {
            foreach ($block->getChildren() as $childBlock) {
                $viewPaths = array_merge($viewPaths, $this->getBlockViewPathsRecursive($childBlock));
            }
        }

        return $viewPaths;
    }

    public function getAllBlocksCustomCss()
    {
        return collect($this->blocks)->map(function ($block) {
            return $this->getBlockCustomCssRecursive($block);
        })->filter()->unique()->implode(' ');
    }

    protected function getBlockCustomCssRecursive($block)
    {
        $css = '';
        $css .= $block->getOtherCssClasses();
        if (method_exists($block, 'getCustomCss')) {
            $css .= $block->getCustomCss();
        }

        if (method_exists($block, 'getChildren')) {
            foreach ($block->getChildren() as $childBlock) {
                $childCss = $this->getBlockCustomCssRecursive($childBlock);
                if (! empty($childCss)) {
                    $css .= ' '.$childCss;
                }
            }
        }

        return $css;
    }
}
