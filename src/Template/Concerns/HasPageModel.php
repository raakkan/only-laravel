<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

trait HasPageModel
{
    protected $pageModel;

    public function setPageModel($model)
    {
        $this->pageModel = $model;
        return $this;
    }

    public function getPageModel()
    {
        return $this->pageModel;
    }

    public function hasPageModel()
    {
        return isset($this->pageModel);
    }
}