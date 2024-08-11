<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Concerns;

use Raakkan\OnlyLaravel\Theme\Facades\TemplateManager;

trait HasModel
{
    protected $model;

    public function setModel($model)
    {
        $this->model = $model;
        
        $this->setModelData();
        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function setModelData()
    {
        if ($this->model) {
            $this->type = $this->model->type;
            $this->location = $this->model->location;
            $this->setBlockSettings($this->model->settings);

            foreach ($this->model->children()->with('children')->get() as $child) {
                // TODO: check block exists or set not found
                $block = TemplateManager::getBlockByName($child->name)->setModel($child);
                
                $this->childrens[] = $block;
            }
        }

        return $this;
    }

    public function hasModel()
    {
        return isset($this->model);
    }
}