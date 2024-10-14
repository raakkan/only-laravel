<?php

namespace Raakkan\OnlyLaravel\Page\Concerns;

use Raakkan\OnlyLaravel\Models\PageModel;

trait HasPageModel
{
    protected $model;
    protected $modelClass = PageModel::class;
    protected $modelData = [];

    public function setModel($model)
    {
        $this->model = $model;
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

    public function getModelClass()
    {
        return $this->modelClass;
    }

    public function setModelClass($modelClass)
    {
        $this->modelClass = $modelClass;
        return $this;
    }

    public function setModelData($modelData)
    {
        $this->modelData = $modelData;
        return $this;
    }

    public function getModelData()
    {
        return $this->modelData;
    }
}