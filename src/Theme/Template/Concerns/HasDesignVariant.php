<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Concerns;

trait HasDesignVariant
{
    protected $designVariant = 'default';

    public function getDesignVariant()
    {
        return $this->designVariant;
    }

    public function setDesignVariant($designVariant)
    {
        $this->designVariant = $designVariant;
        return $this;
    }

    public function getDesignVariants()
    {
    }
}