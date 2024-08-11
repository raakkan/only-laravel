<?php

namespace Raakkan\OnlyLaravel\Theme\Template;

use Raakkan\OnlyLaravel\Theme\Models\ThemeTemplate;
use Raakkan\OnlyLaravel\Theme\Facades\ThemesManager;
use Raakkan\OnlyLaravel\Theme\Template\Blocks\Components\YieldComponent;
use Raakkan\OnlyLaravel\Theme\Template\Blocks\GridBlock;
use Raakkan\OnlyLaravel\Theme\Template\Blocks\FooterBlock;
use Raakkan\OnlyLaravel\Theme\Template\Blocks\HeaderBlock;
use Raakkan\OnlyLaravel\Theme\Template\Blocks\ContentBlock;
use Raakkan\OnlyLaravel\Theme\Template\Concerns\TemplateHandler;
use Raakkan\OnlyLaravel\Theme\Template\Blocks\Components\ImageBlockComponent;

class TemplateManager
{
    use TemplateHandler;
    protected $blocks = [];

    public function getBlocks()
    {
        $blocks = $this->blocks;

        if ($this->getActiveTheme()->includeCoreBlocks()) {
            $blocks = array_merge($this->getCoreBlocks(), $blocks);
        }
        
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

    public function getActiveTheme()
    {
        return ThemesManager::current();
    }
}
