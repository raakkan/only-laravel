<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Concerns;

trait HasDummyState
{
    protected bool $isDummy = false;

    public function setDummy(bool $isDummy = true): self
    {
        $this->isDummy = $isDummy;

        return $this;
    }

    public function isDummy(): bool
    {
        return $this->isDummy;
    }

    public function isReal(): bool
    {
        return !$this->isDummy;
    }
}