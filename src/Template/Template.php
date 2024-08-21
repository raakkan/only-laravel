<?php

namespace Raakkan\OnlyLaravel\Template;

use Illuminate\Contracts\Support\Arrayable;
use Raakkan\OnlyLaravel\Models\TemplateModel;
use Raakkan\OnlyLaravel\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;
use Raakkan\OnlyLaravel\Support\Concerns\HasLabel;
use Raakkan\OnlyLaravel\Template\Concerns\HasBlocks;
use Raakkan\OnlyLaravel\Template\Concerns\HasSource;
use Raakkan\OnlyLaravel\Template\Concerns\HasForPage;
use Raakkan\OnlyLaravel\Template\Concerns\HasMaxWidthSettings;
use Raakkan\OnlyLaravel\Template\Concerns\HasTemplateSettings;

// TODO: add option for setting clear
class Template implements Arrayable
{
    use Makable;
    use HasName;
    use HasLabel;
    use HasBlocks;
    use HasSource;
    use HasForPage;
    use HasTemplateSettings;
    use HasMaxWidthSettings;

    public function __construct($name)
    {
        $this->name = $name;
    }

    protected $model;

    public function setCachedModel($model)
    {
        $templateBlocks = collect($model->blocks)->filter(function ($block) {
            return $block->disabled == 0 && $block->parent_id == null;
        });

        $blocks = collect($model->blocks)->filter(function ($block) {
            return $block->disabled == 0 && $block->parent_id;
        });

        $this->model = $model;

        $this->setTemplateSettings($this->model->settings);
        
        return $this->makeBlocks($templateBlocks, $blocks);
    }

    public function makeBlocks($templateBlocks, $blocks)
    {
        $bt = [];
        foreach ($templateBlocks as $templateBlock) {
            $themeBlock = TemplateManager::getBlockByName($templateBlock->name);

            $templateBlockChildren = collect($blocks)->where('parent_id', $templateBlock->id)->sortBy('order');

            $templateBlock = $this->makeBlockChild($themeBlock, $templateBlockChildren, $blocks);
            
            $bt[] = $themeBlock->setModel($templateBlock);
        }

        $this->blocks = $bt;
        return $this;
    }

    public function makeBlockChild($templateBlock, $templateBlockChildren, $blocks)
    {
        $childBlocks = [];
        foreach ($templateBlockChildren as $block) {
            $blockInstance = TemplateManager::getBlockByName($block->name);

            $blockChildren = collect($blocks)->where('parent_id', $block->id)->sortBy('order');
            if (count($blockChildren) > 0) {
                $blockInstance = $this->makeBlockChild($blockInstance, $blockChildren, $blocks);
            }

            $childBlocks[] = $blockInstance->setModel($block);
        }

        $templateBlock->children($childBlocks);
        return $templateBlock;
    }

    public function setModel($model, $save = true)
    {
        $this->model = $model;
        
        if($save) {
            $this->setModelData();
        }
        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function hasModel()
    {
        return isset($this->model);
    }

    public function setModelData()
    {
        $this->name = $this->model->name;
        $this->source = $this->model->source;
        $this->forPage = $this->model->for_page;
        $this->setTemplateSettings($this->model->settings);
        
        $blocks = [];
        foreach ($this->model->blocks()->with('children')->where('parent_id', null)->where('disabled', 0)->get() as $block) {
            $themeBlock = TemplateManager::getBlockByName($block->name);
            
            $blocks[] = $themeBlock->setModel($block);
        }
        
        $this->blocks = $blocks;
        return $this;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'label' => $this->label ?? $this->name,
            'source' => $this->source,
            'forPage' => $this->forPage,
            'forPageType' => $this->forPageType,
            'blocks' => $this->blocks,
        ];
    }

    public function create()
    {
        if (TemplateModel::where('name', $this->name)->exists()) {
            return;
        }

        $template = TemplateModel::create([
            'name' => $this->name,
            'label' => $this->label ?? $this->name,
            'source' => $this->getSource(),
            'for_page' => $this->forPage,
            'for_page_type' => $this->forPageType,
        ]);

        $this->setModel($template, false);
        $this->storeDefaultSettingsToDatabase();

        foreach ($this->blocks as $block) {
            $block->create($template);
        }
    }

    public function render()
    {
        return view('only-laravel::template.template', [
            'template' => $this
        ]);
    }
}