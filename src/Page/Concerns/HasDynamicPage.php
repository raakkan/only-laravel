<?php

namespace Raakkan\OnlyLaravel\Page\Concerns;

use Raakkan\OnlyLaravel\Models\DynamicPage;

trait HasDynamicPage
{
    protected $dynamicModels = [];
    protected $isDynamic = false;

    public function setDynamicModels(array $dynamicModels)
    {
        $this->dynamicModels = $dynamicModels;
        $this->isDynamic = true;
        return $this;
    }
    
    public function getDynamicModels()
    {
        return $this->dynamicModels;
    }

    public function hasDynamicModels()
    {
        return count($this->dynamicModels) > 0;
    }

    public function isDynamic()
    {
        return $this->isDynamic;
    }
}