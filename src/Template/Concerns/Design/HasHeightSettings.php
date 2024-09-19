<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Illuminate\Support\Arr;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Raakkan\OnlyLaravel\Filament\Components\BlockWidthField;

trait HasHeightSettings
{
    protected $heightSettings = true;
    protected $heightResponsiveSettings = true;
    protected $minHeightSettings = true;
    protected $minHeightResponsiveSettings = true;
    protected $maxHeightSettings = true;
    protected $maxHeightResponsiveSettings = true;
    protected $heightSettingsTabColumn = 2;

    public function getHeight($name = 'height')
    {
        if ($name == 'heightAll') {
            return Arr::get($this->settings, 'onlylaravel.height', []);
        }
        return Arr::get($this->settings, "onlylaravel.height.$name");
    }

    public function getMinHeight($name = 'min_height')
    {
        if ($name == 'minHeightAll') {
            return Arr::get($this->settings, 'onlylaravel.min_height', []);
        }
        return Arr::get($this->settings, "onlylaravel.min_height.$name");
    }

    public function getMaxHeight($name = 'max_height')
    {
        if ($name == 'maxHeightAll') {
            return Arr::get($this->settings, 'onlylaravel.max_height', []);
        }
        return Arr::get($this->settings, "onlylaravel.max_height.$name");
    }

    public function getHeightSettingFields()
    {
        return [
            Tabs::make('Height')
                ->tabs($this->getHeightFieldsTabs())->columns($this->heightSettingsTabColumn),
        ];
    }

    public function getHeightFieldsTabs()
    {
        $tabs = [];
        if ($this->heightSettings) {
            $tabs[] = Tab::make('Height')
                ->schema([
                    BlockWidthField::make('onlylaravel.height')->default(['unit' => $this->getHeight('unit'), 'height' => $this->getHeight()]),
                ]);
        } elseif ($this->heightResponsiveSettings) {
            $tabs[] = Tab::make('Height')
                ->schema([
                    BlockWidthField::make('onlylaravel.height')->default(['unit' => $this->getHeight('unit'), 'height' => $this->getHeight()]),
                    BlockWidthField::make('onlylaravel.height.small')->default(['unit' => $this->getHeight('small.unit'), 'height' => $this->getHeight('small.height')]),
                    BlockWidthField::make('onlylaravel.height.medium')->default(['unit' => $this->getHeight('medium.unit'), 'height' => $this->getHeight('medium.height')]),
                    BlockWidthField::make('onlylaravel.height.large')->default(['unit' => $this->getHeight('large.unit'), 'height' => $this->getHeight('large.height')]),
                    BlockWidthField::make('onlylaravel.height.extra_large')->default(['unit' => $this->getHeight('extra_large.unit'), 'height' => $this->getHeight('extra_large.height')]),
                    BlockWidthField::make('onlylaravel.height.2_extra_large')->default(['unit' => $this->getHeight('2_extra_large.unit'), 'height' => $this->getHeight('2_extra_large.height')]),
                ])->extraAttributes(['style' => 'padding:4px;']);
        }

        if ($this->minHeightSettings) {
            $tabs[] = Tab::make('Min Height')
                ->schema([
                    BlockWidthField::make('onlylaravel.min_height')->default(['unit' => $this->getHeight('unit'), 'height' => $this->getHeight()]),
                ]);
        } elseif ($this->minHeightResponsiveSettings) {
            $tabs[] = Tab::make('Min Height')
                ->schema([
                    BlockWidthField::make('onlylaravel.min_height')->default(['unit' => $this->getHeight('unit'), 'height' => $this->getHeight()]),
                    BlockWidthField::make('onlylaravel.min_height.small')->default(['unit' => $this->getHeight('small.unit'), 'height' => $this->getHeight('small.height')]),
                    BlockWidthField::make('onlylaravel.min_height.medium')->default(['unit' => $this->getHeight('medium.unit'), 'height' => $this->getHeight('medium.height')]),
                    BlockWidthField::make('onlylaravel.min_height.large')->default(['unit' => $this->getHeight('large.unit'), 'height' => $this->getHeight('large.height')]),
                    BlockWidthField::make('onlylaravel.min_height.extra_large')->default(['unit' => $this->getHeight('extra_large.unit'), 'height' => $this->getHeight('extra_large.height')]),
                    BlockWidthField::make('onlylaravel.min_height.2_extra_large')->default(['unit' => $this->getHeight('2_extra_large.unit'), 'height' => $this->getHeight('2_extra_large.height')]),
                ])->extraAttributes(['style' => 'padding:4px;']);
        }

        if ($this->maxHeightSettings) {
            $tabs[] = Tab::make('Max Height')
                ->schema([
                    BlockWidthField::make('onlylaravel.max_height')->default(['unit' => $this->getHeight('unit'), 'height' => $this->getHeight()]),
                ]);
        } elseif ($this->maxHeightResponsiveSettings) {
            $tabs[] = Tab::make('Max Height')
                ->schema([
                    BlockWidthField::make('onlylaravel.max_height')->default(['unit' => $this->getHeight('unit'), 'height' => $this->getHeight()]),
                    BlockWidthField::make('onlylaravel.max_height.small')->default(['unit' => $this->getHeight('small.unit'), 'height' => $this->getHeight('small.height')]),
                    BlockWidthField::make('onlylaravel.max_height.medium')->default(['unit' => $this->getHeight('medium.unit'), 'height' => $this->getHeight('medium.height')]),
                    BlockWidthField::make('onlylaravel.max_height.large')->default(['unit' => $this->getHeight('large.unit'), 'height' => $this->getHeight('large.height')]),
                    BlockWidthField::make('onlylaravel.max_height.extra_large')->default(['unit' => $this->getHeight('extra_large.unit'), 'height' => $this->getHeight('extra_large.height')]),
                    BlockWidthField::make('onlylaravel.max_height.2_extra_large')->default(['unit' => $this->getHeight('2_extra_large.unit'), 'height' => $this->getHeight('2_extra_large.height')]),
                ])->extraAttributes(['style' => 'padding:4px;']);
        }

        return $tabs;
    }

    public function hasHeightSettingsEnabled()
    {
        return $this->heightSettings || $this->heightResponsiveSettings || $this->minHeightSettings || $this->minHeightResponsiveSettings
            || $this->maxHeightSettings || $this->maxHeightResponsiveSettings;
    }

    public function height($value = 100, $unit = 'percentage')
    {
        $this->heightSettings = true;
        Arr::set($this->settings, 'onlylaravel.height.height', $value);
        Arr::set($this->settings, 'onlylaravel.height.unit', $unit);
        return $this;
    }

    public function responsiveHeight($height = [
        'height' => 100,
        'small' => 300,
        'medium' => 400,
        'large' => 500,
        'extra_large' => 600,
        '2_extra_large' => 700
    ], $unit = [
        'unit' => 'percentage',
        'small' => 'pixels',
        'medium' => 'pixels',
        'large' => 'pixels',
        'extra_large' => 'pixels',
        '2_extra_large' => 'pixels'
    ])
    {
        $this->heightResponsiveSettings = true;
        Arr::set($this->settings, 'onlylaravel.height', $height);
        Arr::set($this->settings, 'onlylaravel.height.unit', $unit);
        return $this;
    }

    public function minHeight($value = 100, $unit = 'percentage')
    {
        $this->minHeightSettings = true;
        Arr::set($this->settings, 'onlylaravel.min_height.height', $value);
        Arr::set($this->settings, 'onlylaravel.min_height.unit', $unit);
        return $this;
    }

    public function responsiveMinHeight($height = [
        'height' => 100,
        'small' => 300,
        'medium' => 400,
        'large' => 500,
        'extra_large' => 600,
        '2_extra_large' => 700
    ], $unit = [
        'unit' => 'percentage',
        'small' => 'pixels',
        'medium' => 'pixels',
        'large' => 'pixels',
        'extra_large' => 'pixels',
        '2_extra_large' => 'pixels'
    ])
    {
        $this->minHeightResponsiveSettings = true;
        Arr::set($this->settings, 'onlylaravel.min_height', $height);
        Arr::set($this->settings, 'onlylaravel.min_height.unit', $unit);
        return $this;
    }

    public function maxHeight($value = 100, $unit = 'percentage')
    {
        $this->maxHeightSettings = true;
        Arr::set($this->settings, 'onlylaravel.max_height.height', $value);
        Arr::set($this->settings, 'onlylaravel.max_height.unit', $unit);
        return $this;
    }

    public function responsiveMaxHeight($height = [
        'height' => 100,
        'small' => 300,
        'medium' => 400,
        'large' => 500,
        'extra_large' => 600,
        '2_extra_large' => 700
    ], $unit = [
        'unit' => 'percentage',
        'small' => 'pixels',
        'medium' => 'pixels',
        'large' => 'pixels',
        'extra_large' => 'pixels',
        '2_extra_large' => 'pixels'
    ])
    {
        $this->maxHeightResponsiveSettings = true;
        Arr::set($this->settings, 'onlylaravel.max_height', $height);
        Arr::set($this->settings, 'onlylaravel.max_height.unit', $unit);
        return $this;
    }

    public function enableHeightSettingOnly(array | string $setting = 'heightSettings')
    {
        $this->heightSettings = false;
        $this->heightResponsiveSettings = false;
        $this->minHeightSettings = false;
        $this->minHeightResponsiveSettings = false;
        $this->maxHeightSettings = false;
        $this->maxHeightResponsiveSettings = false;

        if (is_array($setting)) {
            foreach ($setting as $s) {
                $this->{$s} = true;
            }
            return $this;
        }

        $this->{$setting} = true;
        return $this;
    }

    public function getResponsiveHeightStyles($className = null, $setting = 'heightAll')
    {
        if(!$className)
        {
            $className = $this->getName();
        }

        $responsiveHeight = $this->getHeight($setting);
        
        if (is_array($responsiveHeight) && array_key_exists('height', $responsiveHeight)) {
            $styles = $this->generateHeightStyles($className, $responsiveHeight);
            return $styles;
        }
    }

    public function getResponsiveMinHeightStyles($className = null, $setting = 'minHeightAll')
    {
        if(!$className)
        {
            $className = $this->getName();
        }

        $responsiveMinHeight = $this->getMinHeight($setting);

        if (is_array($responsiveMinHeight) && array_key_exists('min_height', $responsiveMinHeight)) {
            $styles = $this->generateHeightStyles($className, $responsiveMinHeight, 'min-height');
            return $styles;
        }
    }

    public function getResponsiveMaxHeightStyles($className = null, $setting = 'maxHeightAll')
    {
        if(!$className)
        {
            $className = $this->getName();
        }
        $responsiveMaxHeight = $this->getMaxHeight($setting);

        if (is_array($responsiveMaxHeight) && array_key_exists('max_height', $responsiveMaxHeight)) {
            $styles = $this->generateHeightStyles($className, $responsiveMaxHeight, 'max-height');
            return $styles;
        }
    }

    private function generateHeightStyles($className, $responsiveHeight, $property = 'height')
    {
        $breakpoints = [
            'small' => '@media (min-width: 640px)',
            'medium' => '@media (min-width: 768px)',
            'large' => '@media (min-width: 1024px)',
            'extra_large' => '@media (min-width: 1280px)',
            '2_extra_large' => '@media (min-width: 1536px)',
        ];

        $height = 'height';

        if($property == 'min-height') {
            $height = 'min_height';
        } elseif($property == 'max-height') {
            $height = 'max_height';
        }

        $styles = [];

        $styles[] = ".$className {";
        $styles[] = "$property: " . ($responsiveHeight[$height] ?? '100') . ($responsiveHeight['unit'] ?? '%') . ';';
        $styles[] = '} ';

        foreach ($breakpoints as $size => $media) {
            if (isset($responsiveHeight[$size]) && isset($responsiveHeight[$size][$height]) && isset($responsiveHeight[$size]['unit'])) {
                $styles[] = $media ? "$media {" : '';
                $styles[] = ".$className {";
                $styles[] = "$property: " . $responsiveHeight[$size][$height] . $responsiveHeight[$size]['unit'] . ';';
                $styles[] = '} ';
                $styles[] = $media ? '} ' : '';
            }
        }

        return implode('', $styles);
    }
}
