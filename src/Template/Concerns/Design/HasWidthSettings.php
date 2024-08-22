<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;

trait HasWidthSettings
{
    protected $widthSettings = true;
    protected $widthResponsiveSettings = true;
    public $widthUnit = 'percentage';
    public $width = 100;
    public $widthSmallUnit = 'pixel';
    public $widthSmall = 640;
    public $widthMediumUnit = 'pixel';
    public $widthMedium = 768;
    public $widthLargeUnit = 'pixel';
    public $widthLarge = 1024;
    public $widthExtraLargeUnit = 'pixel';
    public $widthExtraLarge = 1280;
    public $width2ExtraLargeUnit = 'pixel';
    public $width2ExtraLarge = 1536;

    public function setWidthSettings($settings)
    {
        if (array_key_exists('width', $settings)) {
            $this->widthUnit = $settings['width']['unit'] ?? $this->widthUnit;
            $this->width = $settings['width']['width'] ?? $this->width;
            $this->widthSmallUnit = $settings['width']['small']['unit'] ?? $this->widthSmallUnit;
            $this->widthSmall = $settings['width']['small']['width'] ?? $this->widthSmall;
            $this->widthMediumUnit = $settings['width']['medium']['unit'] ?? $this->widthMediumUnit;
            $this->widthMedium = $settings['width']['medium']['width'] ?? $this->widthMedium;
            $this->widthLargeUnit = $settings['width']['large']['unit'] ?? $this->widthLargeUnit;
            $this->widthLarge = $settings['width']['large']['width'] ?? $this->widthLarge;
            $this->widthExtraLargeUnit = $settings['width']['extra_large']['unit'] ?? $this->widthExtraLargeUnit;
            $this->widthExtraLarge = $settings['width']['extra_large']['width'] ?? $this->widthExtraLarge;
            $this->width2ExtraLargeUnit = $settings['width']['2_extra_large']['unit'] ?? $this->width2ExtraLargeUnit;
            $this->width2ExtraLarge = $settings['width']['2_extra_large']['width'] ?? $this->width2ExtraLarge;
        }
    }

    public function getWidthSettingFields()
    {
        $fields = [];
        if ($this->widthSettings) {
            if ($this->widthResponsiveSettings) {
                $fields[] = Section::make('Width')->schema([
                    Select::make('onlylaravel.width.unit')->options([
                        'pixel' => 'Pixel',
                        'percentage' => 'Percentage',
                    ])->default($this->widthUnit)->label('Width Unit'),
                    TextInput::make('onlylaravel.width.width')->label('Width')->numeric()->default($this->width),
                    Select::make('onlylaravel.width.small.unit')->options([
                        'pixel' => 'Pixel',
                        'percentage' => 'Percentage',
                    ])->default($this->widthSmallUnit)->label('Width Small Unit'),
                    TextInput::make('onlylaravel.width.small.width')->label('Width Small')->numeric()->default($this->widthSmall),
                    Select::make('onlylaravel.width.medium.unit')->options([
                        'pixel' => 'Pixel',
                        'percentage' => 'Percentage',
                    ])->default($this->widthMediumUnit)->label('Width Medium Unit'),
                    TextInput::make('onlylaravel.width.medium.width')->label('Width Medium')->numeric()->default($this->widthMedium),
                    Select::make('onlylaravel.width.large.unit')->options([
                        'pixel' => 'Pixel',
                        'percentage' => 'Percentage',
                    ])->default($this->widthLargeUnit)->label('Width Large Unit'),
                    TextInput::make('onlylaravel.width.large.width')->label('Width Large')->numeric()->default($this->widthLarge),
                    Select::make('onlylaravel.width.extra_large.unit')->options([
                        'pixel' => 'Pixel',
                        'percentage' => 'Percentage',
                    ])->default($this->widthExtraLargeUnit)->label('Width Extra Large Unit'),
                    TextInput::make('onlylaravel.width.extra_large.width')->label('Width Extra Large')->numeric()->default($this->widthExtraLarge),
                    Select::make('onlylaravel.width.2_extra_large.unit')->options([
                        'pixel' => 'Pixel',
                        'percentage' => 'Percentage',
                    ])->default($this->width2ExtraLargeUnit)->label('Width 2 Extra Large Unit'),
                    TextInput::make('onlylaravel.width.2_extra_large.width')->label('Width 2 Extra Large')->numeric()->default($this->width2ExtraLarge),
                ])->compact();
            } else {
                $fields[] = Section::make('Width')->schema([
                    Select::make('onlylaravel.width.unit')->options([
                        'pixel' => 'Pixel',
                        'percentage' => 'Percentage',
                    ])->default($this->widthUnit)->label('Width Unit'),
                    TextInput::make('onlylaravel.width.width')->label('Width')->numeric()->default($this->width),
                ])->compact();
            }
        }
        return $fields;
    }

    public function widthResponsive()
    {
        $this->widthResponsiveSettings = true;
        return $this;
    }

    public function width($value, $unit = 'percentage')
    {
        $this->widthSettings = true;
        if ($value >= 0 && $unit == 'percentage' || $unit == 'pixel') {
            $this->width = $value;
            $this->widthUnit = $unit;
        }
        return $this;
    }

    public function widthSmall($value, $unit = 'pixel')
    {
        $this->widthSettings = true;
        $this->widthResponsiveSettings = true;
        if ($value >= 0 && $unit == 'percentage' || $unit == 'pixel') {
            $this->widthSmall = $value;
            $this->widthSmallUnit = $unit;
        }
        return $this;
    }

    public function widthMedium($value, $unit = 'pixel')
    {
        $this->widthSettings = true;
        $this->widthResponsiveSettings = true;
        if ($value >= 0 && $unit == 'percentage' || $unit == 'pixel') {
            $this->widthMedium = $value;
            $this->widthMediumUnit = $unit;
        }
        return $this;
    }

    public function widthLarge($value, $unit = 'pixel')
    {
        $this->widthSettings = true;
        $this->widthResponsiveSettings = true;
        if ($value >= 0 && $unit == 'percentage' || $unit == 'pixel') {
            $this->widthLarge = $value;
            $this->widthLargeUnit = $unit;
        }
        return $this;
    }

    public function widthExtraLarge($value, $unit = 'pixel')
    {
        $this->widthSettings = true;
        $this->widthResponsiveSettings = true;
        if ($value >= 0 && $unit == 'percentage' || $unit == 'pixel') {
            $this->widthExtraLarge = $value;
            $this->widthExtraLargeUnit = $unit;
        }
        return $this;
    }

    public function width2ExtraLarge($value, $unit = 'pixel')
    {
        $this->widthSettings = true;
        $this->widthResponsiveSettings = true;
        if ($value >= 0 && $unit == 'percentage' || $unit == 'pixel') {
            $this->width2ExtraLarge = $value;
            $this->width2ExtraLargeUnit = $unit;
        }
        return $this;
    }

    public function hasWidthSettingsEnabled()
    {
        return $this->widthSettings;
    }
}
