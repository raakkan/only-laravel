<?php

namespace Raakkan\OnlyLaravel\Admin\Forms\Components;

use Illuminate\Support\Facades\Blade;

class TextInput extends Field
{
    protected ?string $type = 'text';

    protected ?string $icon = null;

    protected ?string $iconRight = null;

    protected ?string $prefix = null;

    protected ?string $suffix = null;

    protected bool $inline = false;

    protected bool $clearable = false;

    protected bool $money = false;

    protected string $locale = 'en-US';

    protected string $wireModel = '';

    protected bool $numeric = false;

    protected bool $integer = false;

    protected ?float $step = null;

    protected ?float $min = null;

    protected ?float $max = null;

    public static function make(string $name): static
    {
        return new static($name);
    }

    public function type(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function icon(?string $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function iconRight(?string $icon): static
    {
        $this->iconRight = $icon;

        return $this;
    }

    public function prefix(?string $prefix): static
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function suffix(?string $suffix): static
    {
        $this->suffix = $suffix;

        return $this;
    }

    public function inline(bool $inline = true): static
    {
        $this->inline = $inline;

        return $this;
    }

    public function clearable(bool $clearable = true): static
    {
        $this->clearable = $clearable;

        return $this;
    }

    public function money(bool $money = true, string $locale = 'en-US'): static
    {
        $this->money = $money;
        $this->locale = $locale;

        return $this;
    }

    public function wireModel(string $wireModel): static
    {
        $this->wireModel = $wireModel;

        return $this;
    }

    public function numeric(bool $numeric = true, ?float $step = null, ?float $min = null, ?float $max = null): static
    {
        $this->numeric = $numeric;
        $this->integer = false; // Reset integer when numeric is set
        $this->step = $step;
        $this->min = $min;
        $this->max = $max;

        return $this;
    }

    public function integer(bool $integer = true, ?int $min = null, ?int $max = null): static
    {
        $this->integer = $integer;
        $this->numeric = false;
        $this->step = 1;
        $this->min = $min;
        $this->max = $max;

        return $this;
    }

    public function render(): string
    {
        return Blade::render(<<<'blade'
            <x-input 
                :type="$type"
                :label="$label" 
                :icon="$icon"
                :icon-right="$iconRight"
                :prefix="$prefix"
                :suffix="$suffix"
                :inline="$inline"
                :clearable="$clearable"
                :money="$money"
                :locale="$locale"
                :hint="$helperText"
                :required="$required"
                :numeric="$numeric"
                :integer="$integer"
                :step="$step"
                :min="$min"
                :max="$max"
                :placeholder="$placeholder"
                wire:model="{{ $wireModel }}"
            />
        blade, [
            'type' => $this->type,
            'label' => $this->label,
            'icon' => $this->icon,
            'iconRight' => $this->iconRight,
            'prefix' => $this->prefix,
            'suffix' => $this->suffix,
            'inline' => $this->inline,
            'clearable' => $this->clearable,
            'money' => $this->money,
            'locale' => $this->locale,
            'helperText' => $this->helperText,
            'required' => $this->required,
            'numeric' => $this->numeric,
            'integer' => $this->integer,
            'step' => $this->step,
            'min' => $this->min,
            'max' => $this->max,
            'placeholder' => $this->placeholder,
            'wireModel' => $this->wireModel,
        ]);
    }
}
