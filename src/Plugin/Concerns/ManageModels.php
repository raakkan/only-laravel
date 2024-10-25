<?php

namespace Raakkan\OnlyLaravel\Plugin\Concerns;

trait ManageModels
{
    protected $models = [];

    public function registerModel($model)
    {
        if (is_subclass_of($model, \Illuminate\Database\Eloquent\Model::class) && $this->isModelHasSlug($model)) {
            $this->models[] = $model;
        } else {
            throw new \InvalidArgumentException('The provided model must be a child of Eloquent Model and have a slug property.');
        }
    }

    public function isModelHasSlug($model)
    {
        $model = new $model;

        return $model->isFillable('slug');
    }

    public function registerModels($models)
    {
        foreach ($models as $model) {
            $this->registerModel($model);
        }
    }

    public function getModels()
    {
        return $this->models;
    }
}
