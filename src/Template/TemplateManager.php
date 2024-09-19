<?php

namespace Raakkan\OnlyLaravel\Template;

use Illuminate\Support\Facades\File;
use Raakkan\OnlyLaravel\Template\Blocks\GridBlock;
use Raakkan\OnlyLaravel\Template\Blocks\FooterBlock;
use Raakkan\OnlyLaravel\Template\Blocks\HeaderBlock;
use Raakkan\OnlyLaravel\Plugin\Facades\PluginManager;
use Raakkan\OnlyLaravel\Template\Blocks\ContentBlock;
use Raakkan\OnlyLaravel\Template\Blocks\NavigationBlock;
use Raakkan\OnlyLaravel\Template\Concerns\TemplateHandler;
use Raakkan\OnlyLaravel\Template\Concerns\ManagesDesignVariants;
use Raakkan\OnlyLaravel\Template\Blocks\Components\HeroComponent;
use Raakkan\OnlyLaravel\Template\Blocks\Components\MenuComponent;
use Raakkan\OnlyLaravel\Template\Blocks\Components\PageDataComponent;
use Raakkan\OnlyLaravel\Template\Blocks\Components\ImageBlockComponent;


class TemplateManager
{
    use TemplateHandler;
    use ManagesDesignVariants;
    protected $blocks = [];

    public function getBlocks()
    {
        $blocks = $this->blocks;
        $appBlocks = $this->getBlocksAndComponentsFromPath(app_path('OnlyLaravel/Template/Blocks'), 'App\\OnlyLaravel\\Template\\Blocks');
        $appComponents = $this->getBlocksAndComponentsFromPath(app_path('OnlyLaravel/Template/Components'), 'App\\OnlyLaravel\\Template\\Components');
        $pluginBlocks = $this->getPluginBlocksAndComponents();

        $blocks = array_merge($this->getCoreBlocks(), $blocks, $appBlocks, $appComponents, $pluginBlocks);

        return $blocks;
    }

    public function getPluginBlocksAndComponents()
    {
        $plugins = collect(PluginManager::getActivatedPlugins());
        
        if($plugins->count() > 0) {
            $blocks = [];
            $components = [];
            foreach($plugins as $plugin) {
                $blocks = $this->getBlocksAndComponentsFromPath($plugin->getPath() . '/src/OnlyLaravel/Template/Blocks', $plugin->getNamespace() . '\\OnlyLaravel\\Template\\Blocks');
                $components = $this->getBlocksAndComponentsFromPath($plugin->getPath() . '/src/OnlyLaravel/Template/Components', $plugin->getNamespace() . '\\OnlyLaravel\\Template\\Components');
            }
            return array_merge($blocks, $components);
        }else{
            return [];
        }
    }

    public function getBlocksAndComponentsFromPath($path, $namespace)
    {
        if (!File::exists($path)) {
            return [];
        }

        $blocks = collect(File::allFiles($path))->map(function ($file) use ($namespace) {
            $className = $namespace . '\\' . $file->getFilenameWithoutExtension();
            $block = new $className();
            $block->source($namespace);
            return $block;
        });

        return $blocks->all();
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
            ContentBlock::make(),
            ImageBlockComponent::make(),
            HeroComponent::make()
        ];
    }
}
