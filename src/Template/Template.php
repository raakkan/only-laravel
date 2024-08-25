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
use Raakkan\OnlyLaravel\Template\Concerns\HasBlockSettings;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasTextSettings;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasColorSettings;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasPaddingSettings;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasSpacingSettings;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasMaxWidthSettings;

// TODO: add option for setting clear
class Template implements Arrayable
{
    use Makable;
    use HasName;
    use HasLabel;
    use HasBlocks;
    use HasSource;
    use HasForPage;
    use HasBlockSettings;
    use HasMaxWidthSettings;
    use HasColorSettings;
    use HasTextSettings;
    use HasPaddingSettings;

    protected $type = 'template';

    public function __construct($name)
    {
        $this->name = $name;
        $this->paddingLeftSettings = true;
        $this->paddingLeftResponsiveSettings = true;
        $this->paddingRightSettings = true;
        $this->paddingRightResponsiveSettings = true;
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

        $this->setBlockSettings($this->model->settings);
        
        return $this->makeBlocks($templateBlocks, $blocks);
    }

    public function makeBlocks($templateBlocks, $blocks)
    {
        $builtBlocks = [];

        foreach ($templateBlocks as $templateBlock) {
            $themeBlock = TemplateManager::getBlockByName($templateBlock->name);
            $templateBlockChildren = $blocks->where('parent_id', $templateBlock->id)->sortBy('order');
            $themeBlock = $this->buildBlockTree($themeBlock, $templateBlockChildren, $blocks);
            $builtBlocks[] = $themeBlock->setModel($templateBlock);
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

            $childBlocks[] = $blockInstance->setModel($block);
        }

        $themeBlock->children($childBlocks);
        return $themeBlock;
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
        $this->setBlockSettings($this->model->settings);
        
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
        $this->storeDefaultSettingsToDatabase();
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