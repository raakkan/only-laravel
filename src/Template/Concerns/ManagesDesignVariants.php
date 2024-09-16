<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

use Raakkan\OnlyLaravel\Template\Blocks\DesignVariant;

trait ManagesDesignVariants
{
    protected array $designVariants = [];

    public function addDesignVariant(DesignVariant $variant): self
    {
        if ($this->checkDesignVariantInstance($variant) && $variant->isValid()) {
            $this->designVariants[$variant->getName()] = $variant;
        } else {
            if (app()->environment('local')) {
                throw new \InvalidArgumentException("Invalid design variant provided");
            } else {
                \Log::warning("Invalid design variant provided");
            }
        }
        return $this;
    }

    public function getDesignVariants(): array
    {
        return $this->designVariants;
    }

    public function getDesignVariant(string $name): ?DesignVariant
    {
        return $this->designVariants[$name] ?? null;
    }

    public function getDesignVariantByFor(string $for): ?DesignVariant
    {
        foreach ($this->designVariants as $variant) {
            if ($variant->getFor() === $for) {
                return $variant;
            }
        }
        return null;
    }

    public function getDesignVariantsByFor(string $for): array
    {
        return array_filter($this->designVariants, function ($variant) use ($for) {
            return $variant->getFor() === $for;
        });
    }

    public function hasDesignVariant(string $name): bool
    {
        return isset($this->designVariants[$name]);
    }

    public function removeDesignVariant(string $name): self
    {
        unset($this->designVariants[$name]);
        return $this;
    }

    public function clearDesignVariants(): self
    {
        $this->designVariants = [];
        return $this;
    }

    public function registerDesignVariant(string $name, $variant): self
    {
        $this->addDesignVariant($variant);
        return $this;
    }

    public function registerDesignVariants(array $variants): self
    {
        foreach ($variants as $variant) {
            $this->addDesignVariant($variant);
        }
        return $this;
    }

    public function checkDesignVariantInstance($variant): bool
    {
        return $variant instanceof DesignVariant;
    }
}


