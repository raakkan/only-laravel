<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Get;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;

trait HasMaxWidthSettings
{
    protected $maxWidthSettings = true;
    protected $maxwidthResponsiveSettings = true;
    public $maxwidthUnit = 'percentage';
    public $maxwidth = 100;
    public $maxwidthSmallUnit = 'pixel';
    public $maxwidthSmall = 640;

    public $maxwidthMediumUnit = 'pixel';
    public $maxwidthMedium = 768;

    public $maxwidthLargeUnit = 'pixel';
    public $maxwidthLarge = 1024;

    public $maxwidthExtraLargeUnit = 'pixel';
    public $maxwidthExtraLarge = 1280;

    public $maxwidth2ExtraLargeUnit = 'pixel';
    public $maxwidth2ExtraLarge = 1536;

    public function setMaxWidthSettings($settings)
    {
        if (array_key_exists('maxwidth', $settings)) {
            $this->maxwidthUnit = $settings['maxwidth']['unit'] ?? $this->maxwidthUnit;
            $this->maxwidth = $settings['maxwidth']['width'] ?? $this->maxwidth;
            $this->maxwidthSmallUnit = $settings['maxwidth']['small']['unit'] ?? $this->maxwidthSmallUnit;
            $this->maxwidthSmall = $settings['maxwidth']['small']['width'] ?? $this->maxwidthSmall;
            $this->maxwidthMediumUnit = $settings['maxwidth']['medium']['unit'] ?? $this->maxwidthMediumUnit;
            $this->maxwidthMedium = $settings['maxwidth']['medium']['width'] ?? $this->maxwidthMedium;
            $this->maxwidthLargeUnit = $settings['maxwidth']['large']['unit'] ?? $this->maxwidthLargeUnit;
            $this->maxwidthLarge = $settings['maxwidth']['large']['width'] ?? $this->maxwidthLarge;
            $this->maxwidthExtraLargeUnit = $settings['maxwidth']['extra_large']['unit'] ?? $this->maxwidthExtraLargeUnit;
            $this->maxwidthExtraLarge = $settings['maxwidth']['extra_large']['width'] ?? $this->maxwidthExtraLarge;
            $this->maxwidth2ExtraLargeUnit = $settings['maxwidth']['2_extra_large']['unit'] ?? $this->maxwidth2ExtraLargeUnit;
            $this->maxwidth2ExtraLarge = $settings['maxwidth']['2_extra_large']['width'] ?? $this->maxwidth2ExtraLarge;
        }
    }

    public function getMaxWidthSettingFields()
    {
        $fields = [];
        if ($this->maxWidthSettings) {
            if ($this->maxwidthResponsiveSettings) {
                $fields[] = Section::make('Max Width')->schema([
                    Select::make('maxwidth.unit')->options([
                        'pixel' => 'Pixel',
                        'percentage' => 'Percentage',
                    ])->default($this->maxwidthUnit)->label('Max Width Unit'),
                    TextInput::make('maxwidth.width')->label('Max Width')->numeric()->default($this->maxwidth),
                    Select::make('maxwidth.small.unit')->options([
                        'pixel' => 'Pixel',
                        'percentage' => 'Percentage',
                    ])->default($this->maxwidthSmallUnit)->label('Max Width Small Unit'),
                    TextInput::make('maxwidth.small.width')->label('Max Width Small')->numeric()->default($this->maxwidthSmall),
                    Select::make('maxwidth.medium.unit')->options([
                        'pixel' => 'Pixel',
                        'percentage' => 'Percentage',
                    ])->default($this->maxwidthMediumUnit)->label('Max Width Medium Unit'),
                    TextInput::make('maxwidth.medium.width')->label('Max Width Medium')->numeric()->default($this->maxwidthMedium),
                    Select::make('maxwidth.large.unit')->options([
                        'pixel' => 'Pixel',
                        'percentage' => 'Percentage',
                    ])->default($this->maxwidthLargeUnit)->label('Max Width Large Unit'),
                    TextInput::make('maxwidth.large.width')->label('Max Width Large')->numeric()->default($this->maxwidthLarge),
                    Select::make('maxwidth.extra_large.unit')->options([
                        'pixel' => 'Pixel',
                        'percentage' => 'Percentage',
                    ])->default($this->maxwidthExtraLargeUnit)->label('Max Width Extra Large Unit'),
                    TextInput::make('maxwidth.extra_large.width')->label('Max Width Extra Large')->numeric()->default($this->maxwidthExtraLarge),
                    Select::make('maxwidth.2_extra_large.unit')->options([
                        'pixel' => 'Pixel',
                        'percentage' => 'Percentage',
                    ])->default($this->maxwidth2ExtraLargeUnit)->label('Max Width 2 Extra Large Unit'),
                    TextInput::make('maxwidth.2_extra_large.width')->label('Max Width 2 Extra Large')->numeric()->default($this->maxwidth2ExtraLarge),
                ])->compact();
            }else{
                $fields[] = Section::make('Max Width')->schema([
                    Select::make('maxwidth.unit')->options([
                        'pixel' => 'Pixel',
                        'percentage' => 'Percentage',
                    ])->default($this->maxwidthUnit)->label('Max Width Unit'),
                    TextInput::make('maxwidth.width')->label('Max Width')->numeric()->default($this->maxwidth),
                ])->compact();
            }
        }

        return $fields;
    }

    public function maxWidthResponsive()
    {
        $this->maxwidthResponsiveSettings = true;
        return $this;
    }

    public function maxWidth($value, $unit = 'percentage')
    {
        $this->maxWidthSettings = true;
        if ($value >= 0 && $unit == 'percentage' || $unit == 'pixel') {
            $this->maxwidth = $value;
            $this->maxwidthUnit = $unit;
        }
        return $this;
    }

    public function maxWidthSmall($value, $unit = 'pixel')
    {
        $this->maxWidthSettings = true;
        $this->maxwidthResponsiveSettings = true;
        if ($value >= 0 && $unit == 'percentage' || $unit == 'pixel') {
            $this->maxwidthSmall = $value;
            $this->maxwidthSmallUnit = $unit;
        }
        return $this;
    }

    public function maxWidthMedium($value, $unit = 'pixel')
    {
        $this->maxWidthSettings = true;
        $this->maxwidthResponsiveSettings = true;
        if ($value >= 0 && $unit == 'percentage' || $unit == 'pixel') {
            $this->maxwidthMedium = $value;
            $this->maxwidthMediumUnit = $unit;
        }
        return $this;
    }

    public function maxWidthLarge($value, $unit = 'pixel')
    {
        $this->maxWidthSettings = true;
        $this->maxwidthResponsiveSettings = true;
        if ($value >= 0 && $unit == 'percentage' || $unit == 'pixel') {
            $this->maxwidthLarge = $value;
            $this->maxwidthLargeUnit = $unit;
        }
        return $this;
    }

    public function maxWidthExtraLarge($value, $unit = 'pixel')
    {
        $this->maxWidthSettings = true;
        $this->maxwidthResponsiveSettings = true;
        if ($value >= 0 && $unit == 'percentage' || $unit == 'pixel') {
            $this->maxwidthExtraLarge = $value;
            $this->maxwidthExtraLargeUnit = $unit;
        }
        return $this;
    }

    public function maxWidth2ExtraLarge($value, $unit = 'pixel')
    {
        $this->maxWidthSettings = true;
        $this->maxwidthResponsiveSettings = true;
        if ($value >= 0 && $unit == 'percentage' || $unit == 'pixel') {
            $this->maxwidth2ExtraLarge = $value;
            $this->maxwidth2ExtraLargeUnit = $unit;
        }
        return $this;
    }

    public function hasMaxWidthSettingsEnabled()
    {
        return $this->maxWidthSettings;
    }
}