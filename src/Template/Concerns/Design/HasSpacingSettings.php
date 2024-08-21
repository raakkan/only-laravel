<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;

trait HasSpacingSettings
{
    protected $spacingSettings = true;
    public $mobileSpacing = 0;
    public $tabletSpacing = 0;
    public $tabletWideSpacing = 0;
    public $laptopSpacing = 0;
    public $desktopSpacing = 0;
    public $desktopWideSpacing = 0;

    public function setSpacingSettings($settings)
    {
        if (array_key_exists('spacing', $settings)) {
            $this->mobileSpacing = $settings['spacing']['mobile'] ?? $this->mobileSpacing;
            $this->tabletSpacing = $settings['spacing']['tablet'] ?? $this->tabletSpacing;
            $this->tabletWideSpacing = $settings['spacing']['tablet_wide'] ?? $this->tabletWideSpacing;
            $this->laptopSpacing = $settings['spacing']['laptop'] ?? $this->laptopSpacing;
            $this->desktopSpacing = $settings['spacing']['desktop'] ?? $this->desktopSpacing;
            $this->desktopWideSpacing = $settings['spacing']['desktop_wide'] ?? $this->desktopWideSpacing;
        }
    }

    public function getSpacingSettingFields()
    {
        if ($this->spacingSettings) {
            return [
                TextInput::make('spacing.mobile')->label('Mobile')->numeric()->suffix('rm'),
                TextInput::make('spacing.tablet')->label('Tablet')->numeric()->suffix('rm'),
                TextInput::make('spacing.tablet_wide')->label('Tablet Wide')->numeric()->suffix('rm'),
                TextInput::make('spacing.laptop')->label('Laptop')->numeric()->suffix('rm'),
                TextInput::make('spacing.desktop')->label('Desktop')->numeric()->suffix('rm'),
                TextInput::make('spacing.desktop_wide')->label('Desktop Wide')->numeric()->suffix('rm'),
            ];
        }
    }

    public function mobileSpacing(int $spacing)
    {
        if ($spacing >= 0) {
            $this->mobileSpacing = $spacing;
        }
        return $this;
    }

    public function tabletSpacing(int $spacing)
    {
        if ($spacing >= 0) {
            $this->tabletSpacing = $spacing;
        }
        return $this;
    }

    public function tabletWideSpacing(int $spacing)
    {
        if ($spacing >= 0) {
            $this->tabletWideSpacing = $spacing;
        }
        return $this;
    }

    public function laptopSpacing(int $spacing)
    {
        if ($spacing >= 0) {
            $this->laptopSpacing = $spacing;
        }
        return $this;
    }

    public function desktopSpacing(int $spacing)
    {
        if ($spacing >= 0) {
            $this->desktopSpacing = $spacing;
        }
        return $this;
    }

    public function desktopWideSpacing(int $spacing)
    {
        if ($spacing >= 0) {
            $this->desktopWideSpacing = $spacing;
        }
        return $this;
    }

    public function hasSpacingSettingsEnabled()
    {
        return $this->spacingSettings;
    }
}
