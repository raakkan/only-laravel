<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Get;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;

trait HasMaxWidthSettings
{
    protected $maxWidthSettings = true;
    public $mobileMaxWidthUnit = 'percentage';
    public $mobileMaxWidth = 100;
    public $tabletMaxWidthUnit = 'pixel';
    public $tabletMaxWidth = 640;
    public $tabletWideMaxWidthUnit = 'pixel';
    public $tabletWideMaxWidth = 1024;
    public $laptopMaxWidthUnit = 'pixel';
    public $laptopMaxWidth = 1280;
    public $desktopMaxWidthUnit = 'pixel';
    public $desktopMaxWidth = 1536;
    public $desktopWideMaxWidthUnit = 'pixel';
    public $desktopWideMaxWidth = 2560;

    public function setMaxWidthSettings($settings)
    {
        if (array_key_exists('maxwidth', $settings)) {
            $this->mobileMaxWidthUnit = $settings['maxwidth']['mobile']['unit'] ?? $this->mobileMaxWidthUnit;
            $this->mobileMaxWidth = $settings['maxwidth']['mobile']['width'] ?? $this->mobileMaxWidth;
            $this->tabletMaxWidthUnit = $settings['maxwidth']['tablet']['unit'] ?? $this->tabletMaxWidthUnit;
            $this->tabletMaxWidth = $settings['maxwidth']['tablet']['width'] ?? $this->tabletMaxWidth;
            $this->tabletWideMaxWidthUnit = $settings['maxwidth']['tablet_wide']['unit'] ?? $this->tabletWideMaxWidthUnit;
            $this->tabletWideMaxWidth = $settings['maxwidth']['tablet_wide']['width'] ?? $this->tabletWideMaxWidth;
            $this->laptopMaxWidthUnit = $settings['maxwidth']['laptop']['unit'] ?? $this->laptopMaxWidthUnit;
            $this->laptopMaxWidth = $settings['maxwidth']['laptop']['width'] ?? $this->laptopMaxWidth;
            $this->desktopMaxWidthUnit = $settings['maxwidth']['desktop']['unit'] ?? $this->desktopMaxWidthUnit;
            $this->desktopMaxWidth = $settings['maxwidth']['desktop']['width'] ?? $this->desktopMaxWidth;
            $this->desktopWideMaxWidthUnit = $settings['maxwidth']['desktop_wide']['unit'] ?? $this->desktopWideMaxWidthUnit;
            $this->desktopWideMaxWidth = $settings['maxwidth']['desktop_wide']['width'] ?? $this->desktopWideMaxWidth;
        }
    }

    public function getMaxWidthSettingFields()
    {
        if ($this->maxWidthSettings) {
            return [
                Section::make('Max Width Mobile')->schema([
                    Select::make('maxwidth.mobile.unit')->label('Unit')
                        ->options([
                            'pixel' => 'Pixel',
                            'percentage' => 'Percentage',
                        ])
                        ->default($this->mobileMaxWidthUnit)
                        ->required()
                        ->live(),
                    TextInput::make('maxwidth.mobile.width')->label('Max Width')->numeric()->default($this->mobileMaxWidth),
                ])->compact(),
                Section::make('Max Width Tablet')->schema([
                    Select::make('maxwidth.tablet.unit')->label('Unit')
                        ->options([
                            'pixel' => 'Pixel',
                            'percentage' => 'Percentage',
                        ])->default($this->tabletMaxWidthUnit)->required()->live(),
                        TextInput::make('maxwidth.tablet.width')->label('Max Width')->numeric()->default($this->tabletMaxWidth),
                ])->compact(),
                Section::make('Max Width Tablet Wide')->schema([
                    Select::make('maxwidth.tablet_wide.unit')->label('Unit')
                        ->options([
                            'pixel' => 'Pixel',
                            'percentage' => 'Percentage',
                        ])->default($this->tabletWideMaxWidthUnit)->required()->live(),
                        TextInput::make('maxwidth.tablet_wide.width')->label('Max Width')->numeric()->default($this->tabletWideMaxWidth),
                ])->compact(),
                Section::make('Max Width Laptop')->schema([
                    Select::make('maxwidth.laptop.unit')->label('Unit')
                        ->options([
                            'pixel' => 'Pixel',
                            'percentage' => 'Percentage',
                        ])->default($this->laptopMaxWidthUnit)->required()->live(),
                        TextInput::make('maxwidth.laptop.width')->label('Max Width')->numeric()->default($this->laptopMaxWidth),
                ])->compact(),
                Section::make('Max Width Desktop')->schema([
                    Select::make('maxwidth.desktop.unit')->label('Unit')
                        ->options([
                            'pixel' => 'Pixel',
                            'percentage' => 'Percentage',
                        ])->default($this->desktopMaxWidthUnit)->required()->live(),
                        TextInput::make('maxwidth.desktop.width')->label('Max Width')->numeric()->default($this->desktopMaxWidth),
                ])->compact(),
                Section::make('Max Width Desktop Wide')->schema([
                    Select::make('maxwidth.desktop_wide.unit')->label('Unit')
                        ->options([
                            'pixel' => 'Pixel',
                            'percentage' => 'Percentage',
                        ])->default($this->desktopWideMaxWidthUnit)->required()->live(),
                        TextInput::make('maxwidth.desktop_wide.width')->label('Max Width')->numeric()->default($this->desktopWideMaxWidth),
                ])->compact(),
            ];
        }
    }

    public function mobileMaxWidth($unit, int $width)
    {
        if ($unit == 'pixel' || $unit == 'percentage' && $width >= 0) {
            $this->mobileMaxWidthUnit = $unit;
            $this->mobileMaxWidth = $width;
        }
        return $this;
    }

    public function tabletMaxWidth($unit, int $width)
    {
        if ($unit == 'pixel' || $unit == 'percentage' && $width >= 0) {
            $this->tabletMaxWidthUnit = $unit;
            $this->tabletMaxWidth = $width;
        }
        return $this;
    }

    public function tabletWideMaxWidth($unit, int $width)
    {
        if ($unit == 'pixel' || $unit == 'percentage' && $width >= 0) {
            $this->tabletWideMaxWidthUnit = $unit;
            $this->tabletWideMaxWidth = $width;
        }
        return $this;
    }

    public function laptopMaxWidth($unit, int $width)
    {
        if ($unit == 'pixel' || $unit == 'percentage' && $width >= 0) {
            $this->laptopMaxWidthUnit = $unit;
            $this->laptopMaxWidth = $width;
        }
        return $this;
    }

    public function desktopMaxWidth($unit, int $width)
    {
        if ($unit == 'pixel' || $unit == 'percentage' && $width >= 0) {
            $this->desktopMaxWidthUnit = $unit;
            $this->desktopMaxWidth = $width;
        }
        return $this;
    }

    public function desktopWideMaxWidth($unit, int $width)
    {
        if ($unit == 'pixel' || $unit == 'percentage' &&  $width >= 0) {
            $this->desktopWideMaxWidthUnit = $unit;
            $this->desktopWideMaxWidth = $width;
        }
        return $this;
    }

    public function hasMaxWidthSettingsEnabled()
    {
        return $this->maxWidthSettings;
    }
}