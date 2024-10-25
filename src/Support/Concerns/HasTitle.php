<?php

namespace Raakkan\OnlyLaravel\Support\Concerns;

trait HasTitle
{
    protected $title;

    protected $subtitle;

    public function setTitle(string|array $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function title(string|array $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function hasTitle(): bool
    {
        return ! empty($this->title);
    }

    public function getTitle(): string|array
    {
        return $this->title;
    }

    public function setSubtitle(string|array $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function subtitle(string|array $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function hasSubtitle(): bool
    {
        return ! empty($this->subtitle);
    }

    public function getSubtitle(): string|array
    {
        return $this->subtitle;
    }
}
