<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

use Closure;

trait HasPageModel
{
    protected $pageModel;
    protected $dummyPageModel;

    public function setPageModel($model)
    {
        $this->pageModel = $model;
        return $this;
    }

    public function getPageModel()
    {
        return $this->pageModel ?? $this->initializeDummyPageModel();
    }

    public function hasPageModel()
    {
        return isset($this->pageModel);
    }

    public function dummyPageModel(string | callable $model)
    {
        $this->dummyPageModel = $model;
        return $this;
    }

    public function initializeDummyPageModel()
    {
        $dummyPageModel = $this->getDummyPageModel();
        if(is_callable($dummyPageModel)) {
            $pageModel = new $dummyPageModel($this);
        } else {
            $pageModel = $dummyPageModel;
        }
        return $pageModel;
    }

    public function getDummyPageModel()
    {
        return $this->dummyPageModel;
    }

    public function setDummyPageModel($dummyPageModel)
    {
        $this->dummyPageModel = $dummyPageModel;
        return $this;
    }
}