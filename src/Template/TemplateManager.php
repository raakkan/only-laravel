<?php

namespace Raakkan\OnlyLaravel\Template;

use Illuminate\Support\Facades\File;
use Raakkan\OnlyLaravel\Template\Blocks\GridBlock;
use Raakkan\OnlyLaravel\Template\Blocks\FooterBlock;
use Raakkan\OnlyLaravel\Template\Blocks\HeaderBlock;
use Raakkan\OnlyLaravel\Template\Blocks\ContentBlock;
use Raakkan\OnlyLaravel\Template\Blocks\NavigationBlock;
use Raakkan\OnlyLaravel\Template\Concerns\TemplateHandler;
use Raakkan\OnlyLaravel\Template\Blocks\Components\MenuComponent;
use Raakkan\OnlyLaravel\Template\Blocks\Components\PageDataComponent;
use Raakkan\OnlyLaravel\Template\Blocks\Components\ImageBlockComponent;


class TemplateManager
{
    use TemplateHandler;
    protected $blocks = [];

    public function getBlocks()
    {
        $blocks = $this->blocks;

        // Collect blocks from app/OnlyLaravel/Template/Blocks directory
        // $blockClasses = collect(File::allFiles(app_path('OnlyLaravel/Template/Blocks')))
        //     ->map(function ($file) {
        //         $className = 'App\\OnlyLaravel\\Template\\Blocks\\' . $file->getFilenameWithoutExtension();
        //         return new $className();
        //     });

        // Collect components from app/OnlyLaravel/Template/Components directory
        $componentClasses = collect(File::allFiles(app_path('OnlyLaravel/Template/Components')))
            ->map(function ($file) {
                $className = 'App\\OnlyLaravel\\Template\\Components\\' . $file->getFilenameWithoutExtension();
                $component = new $className();
                $component->source('app');
                return $component;
            });

        // Merge core blocks, custom blocks, collected blocks, and components
        $blocks = array_merge($this->getCoreBlocks(), $blocks,  $componentClasses->all());

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
            NavigationBlock::make(),
            MenuComponent::make(),
            PageDataComponent::make()
        ];
    }
}
