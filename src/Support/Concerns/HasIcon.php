<?php

namespace Raakkan\OnlyLaravel\Support\Concerns;

trait HasIcon
{
    protected string $icon = '';

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function icon(string $icon): self
    {
        return $this->setIcon($icon);
    }

    public function hasIcon(): bool
    {
        return ! is_null($this->icon) && ! empty($this->icon);
    }
}
