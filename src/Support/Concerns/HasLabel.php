<?php

namespace Raakkan\OnlyLaravel\Support\Concerns;

trait HasLabel
{
    protected string $label;

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function label(string $label): self
    {
        return $this->setLabel($label);
    }

    public function hasLabel(): bool
    {
        return !is_null($this->label);
    }
}