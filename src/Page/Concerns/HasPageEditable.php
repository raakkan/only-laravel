<?php

namespace Raakkan\OnlyLaravel\Page\Concerns;

trait HasPageEditable
{
    protected $isNameEditable = true;
    protected $isSlugEditable = true;

    public function isNameEditable(): bool
    {
        return $this->isNameEditable;
    }

    public function isSlugEditable(): bool
    {
        return $this->isSlugEditable;
    }

    public function setNameEditable(bool $isNameEditable): self
    {
        $this->isNameEditable = $isNameEditable;

        return $this;
    }

    public function setSlugEditable(bool $isSlugEditable): self
    {
        $this->isSlugEditable = $isSlugEditable;

        return $this;
    }

    public function disableNameEditable(): self
    {
        $this->isNameEditable = false;

        return $this;
    }

    public function disableSlugEditable(): self
    {
        $this->isSlugEditable = false;

        return $this;
    }
}