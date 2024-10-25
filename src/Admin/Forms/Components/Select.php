<?php

namespace Raakkan\OnlyLaravel\Admin\Forms\Components;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Blade;

class Select extends Field
{
    protected $options = [];

    protected ?string $optionValue = 'id';

    protected ?string $optionLabel = 'name';

    protected ?string $placeholder = null;

    protected ?string $placeholderValue = null;

    protected string $wireModel = '';

    public static function make(string $name): static
    {
        return new static($name);
    }

    public function options(Collection|array|callable $options): static
    {
        $this->options = $options;

        return $this;
    }

    public function optionValue(string $value): static
    {
        $this->optionValue = $value;

        return $this;
    }

    public function optionLabel(string $label): static
    {
        $this->optionLabel = $label;

        return $this;
    }

    public function placeholder(string $placeholder, ?string $value = null): static
    {
        $this->placeholder = $placeholder;
        $this->placeholderValue = $value;

        return $this;
    }

    public function wireModel(string $wireModel): static
    {
        $this->wireModel = $wireModel;

        return $this;
    }

    public function render(): string
    {
        $options = is_callable($this->options) ? call_user_func($this->options) : $this->options;

        return Blade::render(<<<'blade'
            <x-select 
                :label="$label" 
                :placeholder="$placeholder" 
                :placeholder-value="$placeholderValue"
                :required="$required" 
                :hint="$helperText"
                :options="$options"
                :option-value="$optionValue"
                :option-label="$optionLabel"
                wire:model="{{ $wireModel }}"
            />
        blade, [
            'label' => $this->label,
            'placeholder' => $this->placeholder,
            'placeholderValue' => $this->placeholderValue,
            'required' => $this->required,
            'helperText' => $this->helperText,
            'options' => $options,
            'optionValue' => $this->optionValue,
            'optionLabel' => $this->optionLabel,
            'wireModel' => $this->wireModel,
        ]);
    }
}
