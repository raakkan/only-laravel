<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Illuminate\Support\Arr;
use Raakkan\OnlyLaravel\Filament\Components\BlockWidthField;

trait HasWidthSettings
{
    protected $widthSettings = true;
    protected $widthResponsiveSettings = true;

    public function getWidth($name = 'width')
    {
        return Arr::get($this->settings, "onlylaravel.width.$name");
    }

    public function getWidthSettingFields()
    {
        $fields = [];
        if ($this->widthSettings) {
            if ($this->widthResponsiveSettings) {
                $fields = [
                    BlockWidthField::make('onlylaravel.width')->default(['unit' => $this->getWidth('unit'), 'width' => $this->getWidth()]),
                    BlockWidthField::make('onlylaravel.width.small')->default(['unit' => $this->getWidth('small.unit'), 'width' => $this->getWidth('small.width')]),
                    BlockWidthField::make('onlylaravel.width.medium')->default(['unit' => $this->getWidth('medium.unit'), 'width' => $this->getWidth('medium.width')]),
                    BlockWidthField::make('onlylaravel.width.large')->default(['unit' => $this->getWidth('large.unit'), 'width' => $this->getWidth('large.width')]),
                    BlockWidthField::make('onlylaravel.width.extra_large')->default(['unit' => $this->getWidth('extra_large.unit'), 'width' => $this->getWidth('extra_large.width')]),
                    BlockWidthField::make('onlylaravel.width.2_extra_large')->default(['unit' => $this->getWidth('2_extra_large.unit'), 'width' => $this->getWidth('2_extra_large.width')]),
                ];
            }else{
                $fields[] = BlockWidthField::make('onlylaravel.width')->default(['unit' => $this->getWidth('unit'), 'width' => $this->getWidth()]);
            }
        }
        
        return $fields;
    }

    public function hasWidthSettingsEnabled()
    {
        return $this->widthSettings || $this->widthResponsiveSettings;
    }

    public function width($value = 100, $unit = 'percentage')
    {
        $this->widthSettings = true;
        Arr::set($this->settings, 'onlylaravel.width.width', $value);
        Arr::set($this->settings, 'onlylaravel.width.unit', $unit);
        return $this;
    }

    public function responsiveWidth($width = [
        'width' => 100, 
        'small' => 640, 
        'medium' => 768, 
        'large' => 1024, 
        'extra_large' => 1280, 
        '2_extra_large' => 1536
    ], $unit = [
        'unit' => 'percentage',
        'small' => 'pixels',
        'medium' => 'pixels',
        'large' => 'pixels',
        'extra_large' => 'pixels',
        '2_extra_large' => 'pixels'  
    ])
    {
        $this->widthResponsiveSettings = true;
        Arr::set($this->settings, 'onlylaravel.width', $width);
        Arr::set($this->settings, 'onlylaravel.width.unit', $unit);
        return $this;
    }
}
