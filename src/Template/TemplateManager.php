<?php

namespace Raakkan\OnlyLaravel\Template;

use Raakkan\OnlyLaravel\Template\Blocks\GridBlock;
use Raakkan\OnlyLaravel\Template\Blocks\FooterBlock;
use Raakkan\OnlyLaravel\Template\Blocks\HeaderBlock;
use Raakkan\OnlyLaravel\Template\Blocks\ContentBlock;
use Raakkan\OnlyLaravel\Template\Concerns\TemplateHandler;
use Raakkan\OnlyLaravel\Template\Blocks\Components\YieldComponent;
use Raakkan\OnlyLaravel\Template\Blocks\Components\ImageBlockComponent;


class TemplateManager
{
    use TemplateHandler;
    protected $blocks = [];

    public function getBlocks()
    {
        $blocks = $this->blocks;

        $blocks = array_merge($this->getCoreBlocks(), $blocks);
        
        return $blocks;
    }

    public function getBlockByName($name)
    {
        return collect($this->getBlocks())->first(function ($block) use ($name) {
            return $block->getName() == $name;
        });
    }

    public function registerBlocks($blocks)
    {
        $this->blocks = array_merge($this->blocks, $blocks);
        return $this;
    }

    public function getCoreBlocks()
    {
        return [
            HeaderBlock::make(),
            FooterBlock::make(),
            GridBlock::make(),
            ContentBlock::make(),
            ImageBlockComponent::make(),
            YieldComponent::make()
        ];
    }
}
