<?php

namespace Raakkan\OnlyLaravel\Template;

use Illuminate\Contracts\Support\Arrayable;
use Raakkan\OnlyLaravel\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Support\Concerns\HasLabel;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasCustomStyleSettings;
use Raakkan\OnlyLaravel\Template\Concerns\HasBlockAssets;
use Raakkan\OnlyLaravel\Template\Concerns\HasBlockBuilding;
use Raakkan\OnlyLaravel\Template\Concerns\HasBlocks;
use Raakkan\OnlyLaravel\Template\Concerns\HasBlockSettings;
use Raakkan\OnlyLaravel\Template\Concerns\HasPageModel;
use Raakkan\OnlyLaravel\Template\Concerns\ManageStyle;
use Raakkan\OnlyLaravel\Template\Concerns\ManageTemplateParent;

abstract class BaseTemplate implements Arrayable
{
    use HasBlockAssets;
    use HasBlockBuilding;
    use HasBlocks;
    use HasBlockSettings;
    use HasCustomStyleSettings;
    use HasLabel;
    use HasName;
    use HasPageModel;
    use Makable;
    use ManageStyle;
    use ManageTemplateParent;

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

        if ($save) {
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
            'blocks' => $this->blocks,
        ];
    }
}
