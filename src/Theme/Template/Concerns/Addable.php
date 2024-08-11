<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Concerns;

trait Addable
{
    protected $addable = true;

    public function setAddable($addable)
    {
        $this->addable = $addable;
        return $this;
    }

    public function isAddable()
    {
        return $this->addable;
    }
}