<?php

namespace Raakkan\OnlyLaravel\Support\Concerns;

use Illuminate\Database\Eloquent\Model;

trait HasModel
{
    protected $model;

    public function getModel()
    {
        return $this->model;
    }

    public function setModel(Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function hasModel(): bool
    {
        return isset($this->model) && $this->model instanceof Model;
    }
}
