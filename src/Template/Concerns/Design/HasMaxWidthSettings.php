<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Get;
use Illuminate\Support\Arr;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Raakkan\OnlyLaravel\Filament\Components\BlockWidthField;

trait HasMaxWidthSettings
{
    protected $maxwidthSettings = false;
    protected $maxwidthResponsiveSettings = false;

    public function getMaxWidth($name = 'maxwidth')
    {
        return Arr::get($this->settings, "onlylaravel.maxwidth.$name");
    }

    public function getMaxWidthSettingFields()
    {
        $fields = [];
        if ($this->maxwidthSettings) {
            $fields[] = BlockWidthField::make('onlylaravel.maxwidth')->default(['unit' => $this->getMaxWidth('unit'), 'maxwidth' => $this->getMaxWidth()]);
        }
        
        if ($this->maxwidthResponsiveSettings) {
            $fields = [
                BlockWidthField::make('onlylaravel.maxwidth')->default(['unit' => $this->getMaxWidth('unit'), 'maxwidth' => $this->getMaxWidth()]),
                BlockWidthField::make('onlylaravel.maxwidth.small')->default(['unit' => $this->getMaxWidth('small.unit'), 'maxwidth' => $this->getMaxWidth('small.maxwidth')]),
                BlockWidthField::make('onlylaravel.maxwidth.medium')->default(['unit' => $this->getMaxWidth('medium.unit'), 'maxwidth' => $this->getMaxWidth('medium.maxwidth')]),
                BlockWidthField::make('onlylaravel.maxwidth.large')->default(['unit' => $this->getMaxWidth('large.unit'), 'maxwidth' => $this->getMaxWidth('large.maxwidth')]),
                BlockWidthField::make('onlylaravel.maxwidth.extra_large')->default(['unit' => $this->getMaxWidth('extra_large.unit'), 'maxwidth' => $this->getMaxWidth('extra_large.maxwidth')]),
                BlockWidthField::make('onlylaravel.maxwidth.2_extra_large')->default(['unit' => $this->getMaxWidth('2_extra_large.unit'), 'maxwidth' => $this->getMaxWidth('2_extra_large.maxwidth')]),
            ];
        }
        
        return $fields;
    }
    public function hasMaxWidthSettingsEnabled()
    {
        return $this->maxwidthSettings || $this->maxwidthResponsiveSettings;
    }

    public function maxWidth($value = 100, $unit = 'percentage')
    {
        $this->maxwidthSettings = true;
        Arr::set($this->settings, 'onlylaravel.maxwidth.maxwidth', $value);
        Arr::set($this->settings, 'onlylaravel.maxwidth.unit', $unit);
        return $this;
    }

    public function responsiveMaxWidth($maxwidth = [
        'maxwidth' => 100, 
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
        $this->maxwidthResponsiveSettings = true;
        Arr::set($this->settings, 'onlylaravel.maxwidth', $maxwidth);
        Arr::set($this->settings, 'onlylaravel.maxwidth.unit', $unit);
        return $this;
    }
}