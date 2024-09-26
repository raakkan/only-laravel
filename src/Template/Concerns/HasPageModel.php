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
        return $this->pageModel;
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

    public function useDummyPageModel()
    {
        $dummyPageModel = $this->getDummyPageModel();
        if(is_callable($dummyPageModel)) {
            $this->pageModel = new $dummyPageModel($this);
        } else {
            $this->pageModel = $dummyPageModel;
        }

        return $this;
    }

    public function getDummyPageModel()
    {
        return $this->dummyPageModel;
    }
}