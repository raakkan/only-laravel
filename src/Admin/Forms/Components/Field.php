<?php

namespace Raakkan\OnlyLaravel\Admin\Forms\Components;

use Raakkan\OnlyLaravel\Support\Concerns\HasName;

abstract class Field
{
    use HasName;

    protected string $label;

    protected mixed $value = null;

    protected bool $required = false;

    protected ?string $placeholder = null;

    protected ?string $helperText = null;

    protected mixed $default = null;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->label = ucwords(str_replace(['_', '-'], ' ', $name));
    }

    public function label(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function required(bool $required = true): static
    {
        $this->required = $required;

        return $this;
    }

    public function placeholder(string $placeholder): static
    {
        $this->placeholder = $placeholder;

        return $this;
    }

    public function helperText(string $text): static
    {
        $this->helperText = $text;

        return $this;
    }

    public function default(mixed $default): static
    {
        $this->default = $default;

        return $this;
    }

    public function value(mixed $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): mixed
    {
        return $this->value ?? $this->default;
    }

    public function getDefault(): mixed
    {
        return $this->default;
    }

    public function hasValue(): bool
    {
        return $this->value !== null;
    }

    public function hasDefault(): bool
    {
        return $this->default !== null;
    }

    abstract public function render(): string;
}
