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
use Raakkan\OnlyLaravel\Template\Concerns\HasPageModel;
use Raakkan\OnlyLaravel\Template\Concerns\HasBlockAssets;
use Raakkan\OnlyLaravel\Template\Concerns\HasBlockBuilding;
use Raakkan\OnlyLaravel\Template\Concerns\HasBlockSettings;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasTextSettings;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasWidthSettings;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasPaddingSettings;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasBackgroundSettings;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasCustomStyleSettings;

abstract class BaseTemplate implements Arrayable
{
    use Makable;
    use HasName;
    use HasLabel;
    use HasBlocks;
    use HasSource;
    use HasForPage;
    use HasBlockSettings;
    use HasBackgroundSettings;
    use HasTextSettings;
    use HasPaddingSettings;
    use HasCustomStyleSettings;
    use HasPageModel;
    use HasWidthSettings;
    use HasBlockBuilding;
    use HasBlockAssets;

    protected $model;

    public function initializeFromCachedModel($model)
    {
        $templateBlocks = collect($model->blocks)->filter(function ($block) {
            return $block->disabled == 0 && $block->parent_id == null;
        });

        $blocks = collect($model->blocks)->filter(function ($block) {
            return $block->disabled == 0 && $block->parent_id;
        });

        $this->model = $model;

        $this->setSettings($this->model->settings);
        return $this->makeBlocks($templateBlocks, $blocks);
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
        $this->setSettings($this->model->settings);
        
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
            'for' => $this->forPage,
            'blocks' => $this->blocks,
        ];
    }
}