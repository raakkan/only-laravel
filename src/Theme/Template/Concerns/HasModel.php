<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Concerns;

trait HasModel
{
    protected $model;

    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }
}