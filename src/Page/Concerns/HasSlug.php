<?php

namespace Raakkan\OnlyLaravel\Page\Concerns;

trait HasSlug
{
    protected $slug;

    public function setSlug(string|array $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getSlug(): string|array
    {
        return $this->slug;
    }

    public function hasSlug(): bool
    {
        return isset($this->slug);
    }

    public function slug(string|array $slug): self
    {
        return $this->setSlug($slug);
    }

    public function generateUrl(string|array $slug): string
    {
        return url($slug);
    }
}
