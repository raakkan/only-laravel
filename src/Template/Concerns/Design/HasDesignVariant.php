<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;

trait HasDesignVariant
{
    protected $designVariant = 'default';
    protected $designVariants = [];

    public function getDesignVariant()
    {
        return $this->designVariant;
    }

    public function setDesignVariant($designVariant)
    {
        if (array_key_exists($designVariant, $this->designVariants)) {
            $this->designVariant = $designVariant;
        }
        return $this;
    }

    public function getDesignVariants()
    {
        return $this->designVariants;
    }

    public function hasDesignVariants()
    {
        return count($this->designVariants) > 0;
    }

    public function getDesignVariantSettings()
    {
        if ($this->hasDesignVariants()) {
            return [
                Section::make('Design Variant')->schema([
                    Select::make('onlylaravel.design_variant')->label('Design Variant')->options(function () {
                        return collect($this->designVariants)->mapWithKeys(function ($value, $key) {
                            return [$key => $value['label']];
                        });
                    })->default($this->getDesignVariant()),
                ])->compact()
            ];
        }

        return [];
    }

    public function getDesignVariantAssets()
    {
        if ($this->hasDesignVariants()) {
            return $this->designVariants[$this->designVariant]['assets'] ?? [];
        }
        return [];
    }
}