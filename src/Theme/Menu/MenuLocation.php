<?php

namespace Raakkan\ThemesManager\Menu;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Str;

class MenuLocation implements Arrayable
{
    protected string $name;

    protected string $label;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function make(string $name): self
    {
        return new static($name);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function label(string $label): self
    {
        $this->label = $label;
        return $this;
    }

    public function getLabel(): string
    {
        return $this->label ?? Str::headline(str_replace('_', ' ', $this->name));
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'label' => $this->getLabel(),
        ];
    }
}