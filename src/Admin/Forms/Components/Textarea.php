<?php

namespace Raakkan\OnlyLaravel\Admin\Forms\Components;

use Illuminate\Support\Facades\Blade;

class Textarea extends Field
{
    protected int $rows = 3;
    protected ?int $maxLength = null;
    protected bool $autosize = false;

    protected string $wireModel = '';

    public static function make(string $name): static
    {
        return new static($name);
    }

    public function rows(int $rows): static
    {
        $this->rows = $rows;
        return $this;
    }

    public function maxLength(?int $length): static
    {
        $this->maxLength = $length;
        return $this;
    }

    public function autosize(bool $autosize = true): static
    {
        $this->autosize = $autosize;
        return $this;
    }

    public function wireModel(string $wireModel): static
    {
        $this->wireModel = $wireModel;
        return $this;
    }

    public function render(): string
    {
        return Blade::render(<<<'blade'
            <x-textarea :label="$label" :placeholder="$placeholder" :required="$required" :hint="$helperText" wire:model="{{$wireModel}}" :autosize="$autosize" />
        blade, [
            'label' => $this->label,
            'placeholder' => $this->placeholder,
            'required' => $this->required,
            'helperText' => $this->helperText,
            'wireModel' => $this->wireModel,
            'autosize' => $this->autosize,
        ]);
    }
}

