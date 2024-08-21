<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;

trait HasHeightSettings
{
    protected $heightSettings = true;
    protected $heightResponsiveSettings = true;
    public $heightUnit = 'percentage';
    public $height = 100;
    public $heightSmallUnit = 'pixel';
    public $heightSmall = 300;
    public $heightMediumUnit = 'pixel';
    public $heightMedium = 400;
    public $heightLargeUnit = 'pixel';
    public $heightLarge = 500;
    public $heightExtraLargeUnit = 'pixel';
    public $heightExtraLarge = 600;
    public $height2ExtraLargeUnit = 'pixel';
    public $height2ExtraLarge = 700;

    public function setHeightSettings($settings)
    {
        if (array_key_exists('height', $settings)) {
            $this->heightUnit = $settings['height']['unit'] ?? $this->heightUnit;
            $this->height = $settings['height']['height'] ?? $this->height;
            $this->heightSmallUnit = $settings['height']['small']['unit'] ?? $this->heightSmallUnit;
            $this->heightSmall = $settings['height']['small']['height'] ?? $this->heightSmall;
            $this->heightMediumUnit = $settings['height']['medium']['unit'] ?? $this->heightMediumUnit;
            $this->heightMedium = $settings['height']['medium']['height'] ?? $this->heightMedium;
            $this->heightLargeUnit = $settings['height']['large']['unit'] ?? $this->heightLargeUnit;
            $this->heightLarge = $settings['height']['large']['height'] ?? $this->heightLarge;
            $this->heightExtraLargeUnit = $settings['height']['extra_large']['unit'] ?? $this->heightExtraLargeUnit;
            $this->heightExtraLarge = $settings['height']['extra_large']['height'] ?? $this->heightExtraLarge;
            $this->height2ExtraLargeUnit = $settings['height']['2_extra_large']['unit'] ?? $this->height2ExtraLargeUnit;
            $this->height2ExtraLarge = $settings['height']['2_extra_large']['height'] ?? $this->height2ExtraLarge;
        }
    }

    public function getHeightSettingFields()
    {
        $fields = [];
        if ($this->heightSettings) {
            if ($this->heightResponsiveSettings) {
                $fields[] = Section::make('Height')->schema([
                    Select::make('height.unit')->options([
                        'pixel' => 'Pixel',
                        'percentage' => 'Percentage',
                    ])->default($this->heightUnit)->label('Height Unit'),
                    TextInput::make('height.height')->label('Height')->numeric()->default($this->height),
                    Select::make('height.small.unit')->options([
                        'pixel' => 'Pixel',
                        'percentage' => 'Percentage',
                    ])->default($this->heightSmallUnit)->label('Height Small Unit'),
                    TextInput::make('height.small.height')->label('Height Small')->numeric()->default($this->heightSmall),
                    Select::make('height.medium.unit')->options([
                        'pixel' => 'Pixel',
                        'percentage' => 'Percentage',
                    ])->default($this->heightMediumUnit)->label('Height Medium Unit'),
                    TextInput::make('height.medium.height')->label('Height Medium')->numeric()->default($this->heightMedium),
                    Select::make('height.large.unit')->options([
                        'pixel' => 'Pixel',
                        'percentage' => 'Percentage',
                    ])->default($this->heightLargeUnit)->label('Height Large Unit'),
                    TextInput::make('height.large.height')->label('Height Large')->numeric()->default($this->heightLarge),
                    Select::make('height.extra_large.unit')->options([
                        'pixel' => 'Pixel',
                        'percentage' => 'Percentage',
                    ])->default($this->heightExtraLargeUnit)->label('Height Extra Large Unit'),
                    TextInput::make('height.extra_large.height')->label('Height Extra Large')->numeric()->default($this->heightExtraLarge),
                    Select::make('height.2_extra_large.unit')->options([
                        'pixel' => 'Pixel',
                        'percentage' => 'Percentage',
                    ])->default($this->height2ExtraLargeUnit)->label('Height 2 Extra Large Unit'),
                    TextInput::make('height.2_extra_large.height')->label('Height 2 Extra Large')->numeric()->default($this->height2ExtraLarge),
                ])->compact();
            } else {
                $fields[] = Section::make('Height')->schema([
                    Select::make('height.unit')->options([
                        'pixel' => 'Pixel',
                        'percentage' => 'Percentage',
                    ])->default($this->heightUnit)->label('Height Unit'),
                    TextInput::make('height.height')->label('Height')->numeric()->default($this->height),
                ])->compact();
            }
        }
        return $fields;
    }

    public function heightResponsive()
    {
        $this->heightResponsiveSettings = true;
        return $this;
    }

    public function height($value, $unit = 'percentage')
    {
        $this->heightSettings = true;
        if ($value >= 0 && $unit == 'percentage' || $unit == 'pixel') {
            $this->height = $value;
            $this->heightUnit = $unit;
        }
        return $this;
    }

    public function heightSmall($value, $unit = 'pixel')
    {
        $this->heightSettings = true;
        $this->heightResponsiveSettings = true;
        if ($value >= 0 && $unit == 'percentage' || $unit == 'pixel') {
            $this->heightSmall = $value;
            $this->heightSmallUnit = $unit;
        }
        return $this;
    }

    public function heightMedium($value, $unit = 'pixel')
    {
        $this->heightSettings = true;
        $this->heightResponsiveSettings = true;
        if ($value >= 0 && $unit == 'percentage' || $unit == 'pixel') {
            $this->heightMedium = $value;
            $this->heightMediumUnit = $unit;
        }
        return $this;
    }

    public function heightLarge($value, $unit = 'pixel')
    {
        $this->heightSettings = true;
        $this->heightResponsiveSettings = true;
        if ($value >= 0 && $unit == 'percentage' || $unit == 'pixel') {
            $this->heightLarge = $value;
            $this->heightLargeUnit = $unit;
        }
        return $this;
    }

    public function heightExtraLarge($value, $unit = 'pixel')
    {
        $this->heightSettings = true;
        $this->heightResponsiveSettings = true;
        if ($value >= 0 && $unit == 'percentage' || $unit == 'pixel') {
            $this->heightExtraLarge = $value;
            $this->heightExtraLargeUnit = $unit;
        }
        return $this;
    }

    public function height2ExtraLarge($value, $unit = 'pixel')
    {
        $this->heightSettings = true;
        $this->heightResponsiveSettings = true;
        if ($value >= 0 && $unit == 'percentage' || $unit == 'pixel') {
            $this->height2ExtraLarge = $value;
            $this->height2ExtraLargeUnit = $unit;
        }
        return $this;
    }

    public function hasHeightSettingsEnabled()
    {
        return $this->heightSettings;
    }
}
