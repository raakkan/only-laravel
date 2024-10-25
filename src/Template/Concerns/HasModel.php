<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

trait HasModel
{
    protected $model;

    public function setModel($model)
    {
        $this->model = $model;
        $this->name = $this->model->name;
        $this->type = $this->model->type;
        $this->location = $this->model->location;
        $this->disabled = $this->model->disabled;

        $this->setSettings($this->model->settings);

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
