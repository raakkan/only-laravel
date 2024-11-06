<?php

namespace Raakkan\OnlyLaravel\Page\Concerns;

use Illuminate\Support\Facades\Route;

trait ManageDynamicPages
{
    protected $dynamicModels = [];

    public function addDynamicModel(string $name, string|array $dynamicModel)
    {
        if (is_array($dynamicModel)) {
            $this->dynamicModels[$name] = array_merge(
                $this->dynamicModels[$name] ?? [], 
                $dynamicModel
            );
        } else {
            if (!isset($this->dynamicModels[$name])) {
                $this->dynamicModels[$name] = [];
            }
            if (!in_array($dynamicModel, $this->dynamicModels[$name])) {
                $this->dynamicModels[$name][] = $dynamicModel;
            }
        }

        return $this;
    }

    public function setDynamicModels(array $dynamicModels)
    {
        foreach ($dynamicModels as $name => $dynamicModel) {
            $this->addDynamicModel($name, $dynamicModel);
        }
        
        return $this;
    }

    public function getDynamicModels()
    {
        return $this->dynamicModels;
    }

    public function getDynamicModel(string $name)
    {
        return $this->dynamicModels[$name] ?? [];
    }

    public function hasDynamicModels()
    {
        return count($this->dynamicModels) > 0;
    }
}
