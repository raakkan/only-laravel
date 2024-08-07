<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Concerns;

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
        }
    }
}