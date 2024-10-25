<?php

namespace Raakkan\OnlyLaravel\Support\Concerns;

use Illuminate\Support\Str;

trait HasName
{
    protected string $name = '';

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function name(string $name): self
    {
        return $this->setName($name);
    }

    public function hasName(): bool
    {
        return ! is_null($this->name);
    }

    public function getSanitizedName(): string
    {
        return Str::slug($this->name);
    }
}
