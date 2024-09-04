<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Illuminate\Support\Arr;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Raakkan\OnlyLaravel\Filament\Components\BlockWidthField;

trait HasWidthSettings
{
    protected $widthSettings = true;
    protected $widthResponsiveSettings = true;
    protected $minWidthSettings = true;
    protected $minWidthResponsiveSettings = true;
    protected $maxWidthSettings = true;
    protected $maxWidthResponsiveSettings = true;

    public function getWidth($name = 'width')
    {
        if ($name == 'widthAll') {
            return Arr::get($this->settings, 'onlylaravel.width', []);
        }
        return Arr::get($this->settings, "onlylaravel.width.$name");
    }

    public function getMinWidth($name = 'min_width')
    {
        if ($name == 'minWidthAll') {
            return Arr::get($this->settings, 'onlylaravel.min_width', []);
        }
        return Arr::get($this->settings, "onlylaravel.min_width.$name");
    }

    public function getMaxWidth($name = 'max_width')
    {
        if ($name == 'maxWidthAll') {
            return Arr::get($this->settings, 'onlylaravel.max_width', []);
        }
        return Arr::get($this->settings, "onlylaravel.max_width.$name");
    }

    public function getWidthSettingFields()
    {
        return [
            Tabs::make('Width')
                ->tabs($this->getWidthFieldsTabs())->columns(2),
        ];
    }

    public function getWidthFieldsTabs()
    {
        $tabs = [];
        if ($this->widthSettings) {
            $tabs[] = Tab::make('Width')
                ->schema([
                    BlockWidthField::make('onlylaravel.width')->default(['unit' => $this->getWidth('unit'), 'width' => $this->getWidth()]),
                ]);
        }elseif ($this->widthResponsiveSettings) {
            $tabs[] = Tab::make('Width')
                ->schema([
                    BlockWidthField::make('onlylaravel.width')->default(['unit' => $this->getWidth('unit'), 'width' => $this->getWidth()]),
                    BlockWidthField::make('onlylaravel.width.small')->default(['unit' => $this->getWidth('small.unit'), 'width' => $this->getWidth('small.width')]),
                    BlockWidthField::make('onlylaravel.width.medium')->default(['unit' => $this->getWidth('medium.unit'), 'width' => $this->getWidth('medium.width')]),
                    BlockWidthField::make('onlylaravel.width.large')->default(['unit' => $this->getWidth('large.unit'), 'width' => $this->getWidth('large.width')]),
                    BlockWidthField::make('onlylaravel.width.extra_large')->default(['unit' => $this->getWidth('extra_large.unit'), 'width' => $this->getWidth('extra_large.width')]),
                    BlockWidthField::make('onlylaravel.width.2_extra_large')->default(['unit' => $this->getWidth('2_extra_large.unit'), 'width' => $this->getWidth('2_extra_large.width')]),
                ])->extraAttributes(['style' => 'padding:4px;']);
        }

        if ($this->minWidthSettings) {
            $tabs[] = Tab::make('Min Width')
                ->schema([
                    BlockWidthField::make('onlylaravel.min_width')->default(['unit' => $this->getWidth('unit'), 'width' => $this->getWidth()]),
                ]);
        }elseif ($this->minWidthResponsiveSettings) {
            $tabs[] = Tab::make('Min Width')
                ->schema([
                    BlockWidthField::make('onlylaravel.min_width')->default(['unit' => $this->getWidth('unit'), 'width' => $this->getWidth()]),
                    BlockWidthField::make('onlylaravel.min_width.small')->default(['unit' => $this->getWidth('small.unit'), 'width' => $this->getWidth('small.width')]),
                    BlockWidthField::make('onlylaravel.min_width.medium')->default(['unit' => $this->getWidth('medium.unit'), 'width' => $this->getWidth('medium.width')]),
                    BlockWidthField::make('onlylaravel.min_width.large')->default(['unit' => $this->getWidth('large.unit'), 'width' => $this->getWidth('large.width')]),
                    BlockWidthField::make('onlylaravel.min_width.extra_large')->default(['unit' => $this->getWidth('extra_large.unit'), 'width' => $this->getWidth('extra_large.width')]),
                    BlockWidthField::make('onlylaravel.min_width.2_extra_large')->default(['unit' => $this->getWidth('2_extra_large.unit'), 'width' => $this->getWidth('2_extra_large.width')]),
                ])->extraAttributes(['style' => 'padding:4px;']);
        }

        if ($this->maxWidthSettings) {
            $tabs[] = Tab::make('Max Width')
                ->schema([
                    BlockWidthField::make('onlylaravel.max_width')->default(['unit' => $this->getWidth('unit'), 'width' => $this->getWidth()]),
                ]);
        }elseif ($this->maxWidthResponsiveSettings) {
            $tabs[] = Tab::make('Max Width')
                ->schema([
                    BlockWidthField::make('onlylaravel.max_width')->default(['unit' => $this->getWidth('unit'), 'width' => $this->getWidth()]),
                    BlockWidthField::make('onlylaravel.max_width.small')->default(['unit' => $this->getWidth('small.unit'), 'width' => $this->getWidth('small.width')]),
                    BlockWidthField::make('onlylaravel.max_width.medium')->default(['unit' => $this->getWidth('medium.unit'), 'width' => $this->getWidth('medium.width')]),
                    BlockWidthField::make('onlylaravel.max_width.large')->default(['unit' => $this->getWidth('large.unit'), 'width' => $this->getWidth('large.width')]),
                    BlockWidthField::make('onlylaravel.max_width.extra_large')->default(['unit' => $this->getWidth('extra_large.unit'), 'width' => $this->getWidth('extra_large.width')]),
                    BlockWidthField::make('onlylaravel.max_width.2_extra_large')->default(['unit' => $this->getWidth('2_extra_large.unit'), 'width' => $this->getWidth('2_extra_large.width')]),
                ])->extraAttributes(['style' => 'padding:4px;']);
        }

        return $tabs;
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

    public function minWidth($value = 100, $unit = 'percentage')
    {
        $this->minWidthSettings = true;
        Arr::set($this->settings, 'onlylaravel.min_width.width', $value);
        Arr::set($this->settings, 'onlylaravel.min_width.unit', $unit);
        return $this;
    }

    public function responsiveMinWidth($width = [
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
        $this->minWidthResponsiveSettings = true;
        Arr::set($this->settings, 'onlylaravel.min_width', $width);
        Arr::set($this->settings, 'onlylaravel.min_width.unit', $unit);
        return $this;
    }

    public function maxWidth($value = 100, $unit = 'percentage')
    {
        $this->maxWidthSettings = true;
        Arr::set($this->settings, 'onlylaravel.max_width.width', $value);
        Arr::set($this->settings, 'onlylaravel.max_width.unit', $unit);
        return $this;
    }

    public function responsiveMaxWidth($width = [
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
        $this->maxWidthResponsiveSettings = true;
        Arr::set($this->settings, 'onlylaravel.max_width', $width);
        Arr::set($this->settings, 'onlylaravel.max_width.unit', $unit);
        return $this;
    }

    public function enableWidthSettingOnly(array | string $setting = 'widthSettings')
    {
        $this->widthSettings = false;
        $this->widthResponsiveSettings = false;
        $this->minWidthSettings = false;
        $this->minWidthResponsiveSettings = false;
        $this->maxWidthSettings = false;
        $this->maxWidthResponsiveSettings = false;

        if (is_array($setting)) {
            foreach ($setting as $s) {
                $this->{$s} = true;
            }
            return;
        }

        $this->{$setting} = true;
        return $this;
    }

    public function getResponsiveWidthStyles($className, $setting = 'widthAll')
    {
        $responsiveWidth = $this->getWidth($setting);
        
        if (is_array($responsiveWidth) && array_key_exists('width', $responsiveWidth)) {
            $styles = $this->generateWidthStyles($className, $responsiveWidth);
            return $styles;
        }
    }

    public function getResponsiveMinWidthStyles($className, $setting = 'minWidthAll')
    {
        $responsiveMinWidth = $this->getMinWidth($setting);

        if (is_array($responsiveMinWidth) && array_key_exists('min_width', $responsiveMinWidth)) {
            $styles = $this->generateWidthStyles($className, $responsiveMinWidth, 'min-width');
            return $styles;
        }
    }

    public function getResponsiveMaxWidthStyles($className, $setting = 'maxWidthAll')
    {
        $responsiveMaxWidth = $this->getMaxWidth($setting);

        if (is_array($responsiveMaxWidth) && array_key_exists('max_width', $responsiveMaxWidth)) {
            $styles = $this->generateWidthStyles($className, $responsiveMaxWidth, 'max-width');
            return $styles;
        }
    }

    private function generateWidthStyles($className, $responsiveWidth, $property = 'width')
    {
        $breakpoints = [
            'small' => '@media (min-width: 640px)',
            'medium' => '@media (min-width: 768px)',
            'large' => '@media (min-width: 1024px)',
            'extra_large' => '@media (min-width: 1280px)',
            '2_extra_large' => '@media (min-width: 1536px)',
        ];

        $width = 'width';

        if($property == 'min-width') {
            $width = 'min_width';
        } elseif($property == 'max-width') {
            $width = 'max_width';
        }

        $styles = [];

        $styles[] = ".$className {";
        $styles[] = "$property: " . ($responsiveWidth[$width] ?? '100') . ($responsiveWidth['unit'] ?? '%') . ';';
        $styles[] = '} ';

        foreach ($breakpoints as $size => $media) {
            if (isset($responsiveWidth[$size]) && isset($responsiveWidth[$size][$width]) && isset($responsiveWidth[$size]['unit'])) {
                $styles[] = $media ? "$media {" : '';
                $styles[] = ".$className {";
                $styles[] = "$property: " . $responsiveWidth[$size][$width] . $responsiveWidth[$size]['unit'] . ';';
                $styles[] = '} ';
                $styles[] = $media ? '} ' : '';
            }
        }

        return implode('', $styles);
    }
}
