<?php

namespace Raakkan\OnlyLaravel\Support\Concerns;

trait HasSlug
{
   protected $slug;

   public function setSlug(string $slug): self
   {
       $this->slug = $slug;
       return $this;
   }

   public function getSlug(): string
   {
       return $this->slug;
   }

   public function hasSlug(): bool
   {
       return isset($this->slug);
   }

   public function slug(string $slug): self
   {
       return $this->setSlug($slug);
   }
}