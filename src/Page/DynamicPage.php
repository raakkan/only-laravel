<?php

namespace Raakkan\OnlyLaravel\Page;

class DynamicPage extends BasePage
{
    protected $models = [];

    public function setModels(array $models)
    {
        $this->models = $models;

        return $this;
    }

    public function getModels()
    {
        return $this->models;
    }

    public function hasModels()
    {
        return count($this->models) > 0;
    }
}
