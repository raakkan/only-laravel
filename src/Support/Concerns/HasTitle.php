<?php

namespace Raakkan\OnlyLaravel\Support\Concerns;

trait HasTitle
{
    protected $title;
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function title($title): self
    {
        $this->title = $title;
        return $this;
    }

    public function hasTitle(): bool
    {
        return ! empty($this->title);
    }
    
    public function getTitle(): string
    {
        return $this->title;
    }
}