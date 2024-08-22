<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;

trait HasSpacingSettings
{
    protected $paddingSettings = true;
    protected $marginSettings = true;
    protected $spacingResponsiveSettings = true;

    public $padding = 0;
    public $paddingSmall = 0;
    public $paddingMedium = 0;
    public $paddingLarge = 0;
    public $paddingExtraLarge = 0;
    public $padding2ExtraLarge = 0;

    public $margin = 0;
    public $marginSmall = 0;
    public $marginMedium = 0;
    public $marginLarge = 0;
    public $marginExtraLarge = 0;
    public $margin2ExtraLarge = 0;

    public function setSpacingSettings($settings)
    {
        if (array_key_exists('spacing', $settings)) {
            $this->padding = $settings['spacing']['padding']['padding'] ?? $this->padding;
            $this->paddingSmall = $settings['spacing']['padding']['small'] ?? $this->paddingSmall;
            $this->paddingMedium = $settings['spacing']['padding']['medium'] ?? $this->paddingMedium;
            $this->paddingLarge = $settings['spacing']['padding']['large'] ?? $this->paddingLarge;
            $this->paddingExtraLarge = $settings['spacing']['padding']['extra_large'] ?? $this->paddingExtraLarge;
            $this->padding2ExtraLarge = $settings['spacing']['padding']['2_extra_large'] ?? $this->padding2ExtraLarge;
            $this->margin = $settings['spacing']['margin']['margin'] ?? $this->margin;
            $this->marginSmall = $settings['spacing']['margin']['small'] ?? $this->marginSmall;
            $this->marginMedium = $settings['spacing']['margin']['medium'] ?? $this->marginMedium;
            $this->marginLarge = $settings['spacing']['margin']['large'] ?? $this->marginLarge;
            $this->marginExtraLarge = $settings['spacing']['margin']['extra_large'] ?? $this->marginExtraLarge;
            $this->margin2ExtraLarge = $settings['spacing']['margin']['2_extra_large'] ?? $this->margin2ExtraLarge;
        }
    }

    public function getSpacingSettingFields()
    {
        $fileds = [];
        if ($this->paddingSettings) {
            if ($this->spacingResponsiveSettings) {
                $fileds[] = Section::make('Padding')->schema([
                    TextInput::make('onlylaravel.spacing.padding.padding')->label('Padding')->numeric()->default($this->padding),
                    TextInput::make('onlylaravel.spacing.padding.small')->label('Padding Small')->numeric()->default($this->paddingSmall),
                    TextInput::make('onlylaravel.spacing.padding.medium')->label('Padding Medium')->numeric()->default($this->paddingMedium),
                    TextInput::make('onlylaravel.spacing.padding.large')->label('Padding Large')->numeric()->default($this->paddingLarge),
                    TextInput::make('onlylaravel.spacing.padding.extra_large')->label('Padding Extra Large')->numeric()->default($this->paddingExtraLarge),
                    TextInput::make('onlylaravel.spacing.padding.2_extra_large')->label('Padding 2 Extra Large')->numeric()->default($this->padding2ExtraLarge),
                ])->compact();
            } else {
                $fileds[] = Section::make('Padding')->schema([
                    TextInput::make('onlylaravel.spacing.padding')->label('Padding')->numeric()->default($this->padding),
                ])->compact();
            }
            
        }

        if ($this->marginSettings) {
            if ($this->spacingResponsiveSettings) {
                $fileds[] = Section::make('Margin')->schema([
                    TextInput::make('onlylaravel.spacing.margin.margin')->label('Margin')->numeric()->default($this->margin),
                    TextInput::make('onlylaravel.spacing.margin.small')->label('Margin Small')->numeric()->default($this->marginSmall),
                    TextInput::make('onlylaravel.spacing.margin.medium')->label('Margin Medium')->numeric()->default($this->marginMedium),
                    TextInput::make('onlylaravel.spacing.margin.large')->label('Margin Large')->numeric()->default($this->marginLarge),
                    TextInput::make('onlylaravel.spacing.margin.extra_large')->label('Margin Extra Large')->numeric()->default($this->marginExtraLarge),
                    TextInput::make('onlylaravel.spacing.margin.2_extra_large')->label('Margin 2 Extra Large')->numeric()->default($this->margin2ExtraLarge),
                ])->compact();
            } else {
                $fileds[] = Section::make('Margin')->schema([
                    TextInput::make('onlylaravel.spacing.margin')->label('Margin')->numeric()->default($this->margin),
                ])->compact();
            }
        }

        return $fileds;
    }

    public function padding($value)
    {
        $this->paddingSettings = true;
        if ($value >= 0) {
            $this->padding = $value;
        }
        return $this;
    }

    public function margin($value)
    {
        $this->marginSettings = true;
        if ($value >= 0) {
            $this->margin = $value;
        }
        return $this;
    }

    public function spacingResponsive()
    {
        $this->spacingResponsiveSettings = true;
        return $this;
    }

    public function paddingSmall($value)
    {
        $this->paddingSettings = true;
        $this->spacingResponsiveSettings = true;
        if ($value >= 0) {
            $this->paddingSmall = $value;
        }
        return $this;
    }

    public function marginSmall($value)
    {
        $this->marginSettings = true;
        $this->spacingResponsiveSettings = true;
        if ($value >= 0) {
            $this->marginSmall = $value;
        }
        return $this;
    }

    public function paddingMedium($value)
    {
        $this->paddingSettings = true;
        $this->spacingResponsiveSettings = true;
        if ($value >= 0) {
            $this->paddingMedium = $value;
        }
        return $this;
    }

    public function marginMedium($value)
    {
        $this->marginSettings = true;
        $this->spacingResponsiveSettings = true;
        if ($value >= 0) {
            $this->marginMedium = $value;
        }
        return $this;
    }

    public function paddingLarge($value)
    {
        $this->paddingSettings = true;
        $this->spacingResponsiveSettings = true;
        if ($value >= 0) {
            $this->paddingLarge = $value;
        }
        return $this;
    }

    public function marginLarge($value)
    {
        $this->marginSettings = true;
        $this->spacingResponsiveSettings = true;
        if ($value >= 0) {
            $this->marginLarge = $value;
        }
        return $this;
    }

    public function paddingExtraLarge($value)
    {
        $this->paddingSettings = true;
        $this->spacingResponsiveSettings = true;
        if ($value >= 0) {
            $this->paddingExtraLarge = $value;
        }
        return $this;
    }

    public function marginExtraLarge($value)
    {
        $this->marginSettings = true;
        $this->spacingResponsiveSettings = true;
        if ($value >= 0) {
            $this->marginExtraLarge = $value;
        }
        return $this;
    }

    public function padding2ExtraLarge($value)
    {
        $this->paddingSettings = true;
        $this->spacingResponsiveSettings = true;
        if ($value >= 0) {
            $this->padding2ExtraLarge = $value;
        }
        return $this;
    }

    public function margin2ExtraLarge($value)
    {
        $this->marginSettings = true;
        $this->spacingResponsiveSettings = true;
        if ($value >= 0) {
            $this->margin2ExtraLarge = $value;
        }
        return $this;
    }

    public function hasSpacingSettingsEnabled()
    {
        return $this->paddingSettings || $this->marginSettings;
    }
}
