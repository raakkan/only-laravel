<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Arr;

trait HasBorderSettings
{
    protected $borderSettings = true;

    protected $borderRadiusSettings = true;

    protected $borderWidthSettings = true;

    protected $borderColorSettings = true;

    protected $borderStyleSettings = true;

    public function getBorder($name = 'border')
    {
        if ($name == 'borderAll') {
            return Arr::get($this->settings, 'onlylaravel.border', []);
        }

        return Arr::get($this->settings, "onlylaravel.border.$name");
    }

    public function getBorderSettingFields()
    {
        return [
            Tabs::make('Border')
                ->tabs($this->getBorderFieldsTabs())->columns(2),
        ];
    }

    public function getBorderFieldsTabs()
    {
        $tabs = [];

        $tabs[] = Tab::make('Border')
            ->schema([
                TextInput::make('onlylaravel.border.radius')->label('Border Radius')->numeric()->default($this->getBorder('radius')),
                TextInput::make('onlylaravel.border.width')->label('Border Width')->numeric()->default($this->getBorder('width')),
                ColorPicker::make('onlylaravel.border.color')->label('Border Color')->default($this->getBorder('color')),
                Select::make('onlylaravel.border.style')->label('Border Style')->options([
                    'none' => 'None',
                    'solid' => 'Solid',
                    'dashed' => 'Dashed',
                    'dotted' => 'Dotted',
                    'double' => 'Double',
                    'groove' => 'Groove',
                    'ridge' => 'Ridge',
                    'inset' => 'Inset',
                    'outset' => 'Outset',
                ])->default($this->getBorder('style')),
            ]);

        return $tabs;
    }

    public function hasBorderSettingsEnabled()
    {
        return $this->borderSettings || $this->borderRadiusSettings
            || $this->borderWidthSettings || $this->borderColorSettings || $this->borderStyleSettings;
    }

    public function border($radius = 0, $width = 0, $color = '#000000', $style = 'none')
    {
        $this->borderSettings = true;
        Arr::set($this->settings, 'onlylaravel.border', [
            'radius' => $radius,
            'width' => $width,
            'color' => $color,
            'style' => $style,
        ]);

        return $this;
    }

    public function enableBorderSettingOnly(array|string $setting = 'borderSettings')
    {
        $this->borderSettings = false;
        $this->borderRadiusSettings = false;
        $this->borderWidthSettings = false;
        $this->borderColorSettings = false;
        $this->borderStyleSettings = false;

        if (is_array($setting)) {
            foreach ($setting as $s) {
                $this->{$s} = true;
            }

            return;
        }

        $this->{$setting} = true;
    }

    public function getBorderStyles($className)
    {
        $border = $this->getBorder('borderAll');

        if (is_array($border) && array_key_exists('radius', $border) && array_key_exists('width', $border)) {
            $styles = $this->generateBorderStyles($className, $border);

            return $styles;
        }
    }

    private function generateBorderStyles($className, $border)
    {
        $styles = [];

        $styles[] = ".$className {";
        $styles[] = 'border-radius: '.($border['radius'] ?? '0').'rem;';
        $styles[] = 'border-width: '.($border['width'] ?? '0').'rem;';
        $styles[] = 'border-color: '.($border['color'] ?? '#000000').';';
        $styles[] = 'border-style: '.($border['style'] ?? 'none').';';
        $styles[] = '} ';

        return implode('', $styles);
    }
}
