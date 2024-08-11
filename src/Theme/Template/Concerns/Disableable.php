<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Concerns;

trait Disableable
{
    protected $disable = false;
    public function setDisable($disable)
    {
        $this->disable = $disable;
        return $this;
    }

    public function isDisable()
    {
        return $this->disable;
    }
}