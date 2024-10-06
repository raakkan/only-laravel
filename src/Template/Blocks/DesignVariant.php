<?php

namespace Raakkan\OnlyLaravel\Template\Blocks;

use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\HasLabel;

class DesignVariant
{
    use HasName;
    use HasLabel;
    protected string $for;
    protected string $view;
    protected string $viewPath;
    protected string $css;

    public static function make(string $name): self
    {
        return new self($name);
    }

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getFor(): string
    {
        return $this->for;
    }

    public function getView(): string
    {
        return $this->view;
    }

    public function getViewPath(): string
    {
        return $this->viewPath;
    }

    public function for(string $for): self
    {
        $this->for = $for;
        return $this;
    }

    public function hasView(): bool
    {
        return isset($this->view) && $this->view !== null;
    }

    public function hasViewPath(): bool
    {
        return isset($this->viewPath) && $this->viewPath !== null;
    }

    public function hasFor(): bool
    {
        return isset($this->for) && $this->for !== null;
    }

    public function css(string $css): self
    {
        $this->css = $css;
        return $this;
    }

    public function getCss(): string
    {
        return $this->css;
    }

    public function view(string $view): self
    {
        $this->view = $view;
        return $this;
    }

    public function viewPath(string $viewPath): self
    {
        $this->viewPath = $viewPath;
        return $this;
    }

    public function hasCss(): bool
    {
        return isset($this->css) && $this->css !== null;
    }

    public function isValid(): bool
    {
        return $this->hasView() && $this->hasFor() && $this->hasLabel() && $this->hasName();
    }
}
