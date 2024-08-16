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


}