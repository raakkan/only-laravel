<?php

namespace Raakkan\OnlyLaravel\Support\Sitemap;

trait HandleModels
{
    protected $models = [];

    public function getModels(): array
    {
        return $this->models;
    }

    public function registerModel(string $model)
    {
        if (! in_array($model, $this->models)) {
            $this->models[] = $model;
        }
    }

    public function registerModels(array $models)
    {
        $this->models = array_unique(array_merge($this->models, $models));
    }
}
