<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Illuminate\Support\Arr;
use Raakkan\OnlyLaravel\Filament\Components\BlockWidthField;

trait HasHeightSettings
{
    protected $heightSettings = false;
    protected $heightResponsiveSettings = false;

    public function getHeight($name = 'height')
    {
        return Arr::get($this->settings, "onlylaravel.height.$name");
    }

    public function getHeightSettingFields()
    {
        $fields = [];
        if ($this->heightSettings) {
            $fields[] = BlockWidthField::make('onlylaravel.height')->default(['unit' => $this->getHeight('unit'), 'height' => $this->getHeight()]);
        }
        
        if ($this->heightResponsiveSettings) {
            $fields = [
                BlockWidthField::make('onlylaravel.height')->default(['unit' => $this->getHeight('unit'), 'height' => $this->getHeight()]),
                BlockWidthField::make('onlylaravel.height.small')->default(['unit' => $this->getHeight('small.unit'), 'height' => $this->getHeight('small.height')]),
                BlockWidthField::make('onlylaravel.height.medium')->default(['unit' => $this->getHeight('medium.unit'), 'height' => $this->getHeight('medium.height')]),
                BlockWidthField::make('onlylaravel.height.large')->default(['unit' => $this->getHeight('large.unit'), 'height' => $this->getHeight('large.height')]),
                BlockWidthField::make('onlylaravel.height.extra_large')->default(['unit' => $this->getHeight('extra_large.unit'), 'height' => $this->getHeight('extra_large.height')]),
                BlockWidthField::make('onlylaravel.height.2_extra_large')->default(['unit' => $this->getHeight('2_extra_large.unit'), 'height' => $this->getHeight('2_extra_large.height')]),
            ];
        }
        
        return $fields;
    }

    public function hasHeightSettingsEnabled()
    {
        return $this->heightSettings || $this->heightResponsiveSettings;
    }

    public function height($value = 100, $unit = 'percentage')
    {
        $this->heightSettings = true;
        Arr::set($this->settings, 'onlylaravel.height.height', $value);
        Arr::set($this->settings, 'onlylaravel.height.unit', $unit);
        return $this;
    }

    public function responsiveHeight($height = [
        'height' => 100, 
        'small' => 300, 
        'medium' => 400, 
        'large' => 500, 
        'extra_large' => 600, 
        '2_extra_large' => 700
    ], $unit = [
        'unit' => 'percentage',
        'small' => 'pixels',
        'medium' => 'pixels',
        'large' => 'pixels',
        'extra_large' => 'pixels',
        '2_extra_large' => 'pixels'  
    ])
    {
        $this->heightResponsiveSettings = true;
        Arr::set($this->settings, 'onlylaravel.height', $height);
        Arr::set($this->settings, 'onlylaravel.height.unit', $unit);
        return $this;
    }
}
