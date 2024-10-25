<?php

namespace Raakkan\OnlyLaravel\Admin\Forms\Components;

use Illuminate\Support\Facades\Blade;

class Toggle extends Field
{
    protected bool $right = false;

    protected bool $tight = false;

    protected ?string $hint = null;

    protected string $wireModel = '';

    public static function make(string $name): static
    {
        return new static($name);
    }

    public function right(bool $right = true): static
    {
        $this->right = $right;

        return $this;
    }

    public function tight(bool $tight = true): static
    {
        $this->tight = $tight;

        return $this;
    }

    public function hint(?string $hint): static
    {
        $this->hint = $hint;

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
            <x-toggle 
                :label="$label" 
                :hint="$hint"
                :right="$right"
                :tight="$tight"
                :required="$required"
                wire:model="{{$wireModel}}"
            />
        blade, [
            'label' => $this->label,
            'hint' => $this->hint,
            'right' => $this->right,
            'tight' => $this->tight,
            'required' => $this->required,
            'wireModel' => $this->wireModel,
        ]);
    }
}
