<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

use Raakkan\OnlyLaravel\Facades\TemplateManager;

trait HasModel
{
    protected $model;

    public function setModel($model)
    {
        $this->model = $model;
        
        $this->type = $this->model->type;
        $this->location = $this->model->location;
        $this->disabled = $this->model->disabled;
        
        $this->setBlockSettings($this->model->settings);
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
}