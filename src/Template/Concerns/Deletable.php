<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

trait Deletable
{
    protected $deletable = true;

    public function deletable($deletable)
    {
        $this->deletable = $deletable;

        return $this;
    }

    public function setDeletable($deletable)
    {
        $this->deletable = $deletable;

        return $this;
    }

    public function isDeletable()
    {
        return $this->deletable;
    }
}