<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Raakkan\OnlyLaravel\Template\Blocks\DesignVariant;

trait HasDesignVariant
{
    protected $designVariant = 'default';
    protected $designVariants = [];

    public function getDesignVariants()
    {
        return [];
    }

    public function getDesignVariantSettings()
    {
        if ($this->hasDesignVariants()) {
            return [
                Section::make('Design Variant')->schema([
                    Select::make('onlylaravel.design_variant')->label('Design Variant')->options(function () {
                        return collect($this->getComponentDesignVariants())->mapWithKeys(function (DesignVariant $designVariant) {
                            return [$designVariant->getName() => $designVariant->getLabel()];
                        });
                    })->default($this->getDesignVariant()),
                ])->compact()
            ];
        }

        return [];
    }

    public function getComponentDesignVariants()
    {
        $designVariants = array_merge($this->designVariants, $this->getDesignVariants(), app('template-manager')->getDesignVariantsByFor($this->getName()));
        return collect($designVariants)->filter(function ($designVariant) {
            return $designVariant instanceof DesignVariant && $designVariant->isValid();
        });
    }

    public function getDesignVariantViewByName($name)
    {
        $variant = collect($this->getComponentDesignVariants())->first(function (DesignVariant $designVariant) use ($name) {
            return $designVariant->getName() == $name;
        });

        if (!$variant) {
            return null;
        }

        return $variant->getView();
    }

    public function hasDesignVariant($name)
    {
        return collect($this->getComponentDesignVariants())->first(function (DesignVariant $designVariant) use ($name) {
            return $designVariant->getName() == $name;
        });
    }

    public function getDesignVariantCssByName($name)
    {
        $variant = collect($this->getComponentDesignVariants())->first(function (DesignVariant $designVariant) use ($name) {
            return $designVariant->getName() == $name;
        });

        if (!$variant || !$variant->hasCss()) {
            return null;
        }

        return $variant->getCss();
    }

    public function getActiveDesignVariantCss()
    {
        if ($this->getActiveDesignVariant()) {
            return $this->getDesignVariantCssByName($this->getActiveDesignVariant()->getName());
        }

        return null;
    }

    public function getActiveDesignVariantView()
    {
        if ($this->getActiveDesignVariant() && $this->getActiveDesignVariant()->hasView()) {
            return $this->getActiveDesignVariant()->getView();
        }

        return null;
    }

    public function getActiveDesignVariantViewPath()
    {
        if ($this->getActiveDesignVariant() && $this->getActiveDesignVariant()->hasViewPath()) {
            return $this->getActiveDesignVariant()->getViewPath();
        }

        return null;
    }

    public function hasDesignVariants()
    {
        return count($this->getComponentDesignVariants()) > 0;
    }

    public function getDesignVariant()
    {
        return $this->designVariant;
    }

    public function setDesignVariant($designVariant)
    {
        if (!$this->hasDesignVariant($designVariant)) {
            return $this;
        }

        $this->designVariant = $designVariant;
        return $this;
    }

    public function getActiveDesignVariant()
    {
        if ($this->hasDesignVariants() && $this->getDesignVariant()) {
            return collect($this->getComponentDesignVariants())->first(function (DesignVariant $designVariant) {
                return $designVariant->getName() == $this->getDesignVariant();
            });
        }

        return null;
    }

    public function designVariant($name)
    {
        return $this->setDesignVariant($name);
    }
}