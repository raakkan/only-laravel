<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

use Raakkan\OnlyLaravel\Template\Models\DummyPageModel;

trait HandleDummyPageModels
{
    protected $dummyPageModels = [];

    public function getDummyPageModels()
    {
        return $this->dummyPageModels;
    }

    public function hasDummyPageModel($for)
    {
        return isset($this->dummyPageModels[$for]);
    }

    public function registerDummyPageModels(array $dummyPageModels)
    {
        foreach ($dummyPageModels as $dummyPageModel) {
            if ($dummyPageModel instanceof DummyPageModel) {
                $this->registerDummyPageModel($dummyPageModel);
            }
        }
        return $this;
    }

    public function registerDummyPageModel(DummyPageModel $dummyPageModel)
    {
        $this->dummyPageModels[$dummyPageModel->getFor()] = $dummyPageModel;
        return $this;
    }

    public function getDummyPageModel($for)
    {
        if(!$this->hasDummyPageModel($for)) {
            return null;
        }
        return $this->dummyPageModels[$for];
    }
}