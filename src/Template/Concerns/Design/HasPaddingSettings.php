<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Arr;
use Raakkan\OnlyLaravel\Filament\Components\BlockResponsiveNumberField;

trait HasPaddingSettings
{
    protected $paddingSettings = true;

    protected $paddingResponsiveSettings = true;

    protected $paddingLeftSettings = true;

    protected $paddingLeftResponsiveSettings = true;

    protected $paddingRightSettings = true;

    protected $paddingRightResponsiveSettings = true;

    protected $paddingTopSettings = true;

    protected $paddingTopResponsiveSettings = true;

    protected $paddingBottomSettings = true;

    protected $paddingBottomResponsiveSettings = true;

    protected $paddingXSettings = true;

    protected $paddingXResponsiveSettings = true;

    protected $paddingYSettings = true;

    protected $paddingYResponsiveSettings = true;

    public function getPadding($name = 'padding')
    {
        if ($name == 'paddingAll') {
            return Arr::get($this->settings, 'onlylaravel.padding', []);
        }

        return Arr::get($this->settings, "onlylaravel.padding.$name");
    }

    public function getPaddingSettingFields()
    {
        return [
            Tabs::make('Padding')
                ->tabs($this->getPaddingFieldsTabs()),
        ];
    }

    public function getPaddingFieldsTabs()
    {
        $tabs = [];

        if ($this->paddingSettings) {
            $tabs[] = Tab::make('Padding')
                ->schema([
                    TextInput::make('onlylaravel.padding.padding')->label('Padding')->numeric()->extraAttributes(['style' => 'padding:0;'])->default($this->getPadding()),
                ]);
        } elseif ($this->paddingResponsiveSettings) {
            $tabs[] = Tab::make('Padding')
                ->schema([
                    BlockResponsiveNumberField::make('onlylaravel.padding')->label('Padding')->default($this->getPadding('paddingAll')),
                ])->extraAttributes(['style' => 'padding:4px;']);
        }

        if ($this->paddingLeftSettings) {
            $tabs[] = Tab::make('Left')
                ->schema([
                    TextInput::make('onlylaravel.padding.left.padding')->label('Padding Left')->numeric()->extraAttributes(['style' => 'padding:0;'])->default($this->getPadding('left.padding')),
                ]);
        } elseif ($this->paddingLeftResponsiveSettings) {
            $tabs[] = Tab::make('Left')
                ->schema([
                    BlockResponsiveNumberField::make('onlylaravel.padding.left')->label('Padding Left')->default($this->getPadding('left')),
                ])->extraAttributes(['style' => 'padding:4px;']);
        }

        if ($this->paddingRightSettings) {
            $tabs[] = Tab::make('Right')
                ->schema([
                    TextInput::make('onlylaravel.padding.right.padding')->label('Padding Right')->numeric()->extraAttributes(['style' => 'padding:0;'])->default($this->getPadding('right.padding')),
                ]);
        } elseif ($this->paddingRightResponsiveSettings) {
            $tabs[] = Tab::make('Right')
                ->schema([
                    BlockResponsiveNumberField::make('onlylaravel.padding.right')->label('Padding Right')->default($this->getPadding('right')),
                ])->extraAttributes(['style' => 'padding:4px;']);
        }

        if ($this->paddingTopSettings) {
            $tabs[] = Tab::make('Top')
                ->schema([
                    TextInput::make('onlylaravel.padding.top.padding')->label('Padding Top')->numeric()->extraAttributes(['style' => 'padding:0;'])->default($this->getPadding('top.padding')),
                ]);
        } elseif ($this->paddingTopResponsiveSettings) {
            $tabs[] = Tab::make('Top')
                ->schema([
                    BlockResponsiveNumberField::make('onlylaravel.padding.top')->label('Padding Top')->default($this->getPadding('top')),
                ])->extraAttributes(['style' => 'padding:4px;']);
        }

        if ($this->paddingBottomSettings) {
            $tabs[] = Tab::make('Bottom')
                ->schema([
                    TextInput::make('onlylaravel.padding.bottom.padding')->label('Padding Bottom')->numeric()->extraAttributes(['style' => 'padding:0;'])->default($this->getPadding('bottom.padding')),
                ]);
        } elseif ($this->paddingBottomResponsiveSettings) {
            $tabs[] = Tab::make('Bottom')
                ->schema([
                    BlockResponsiveNumberField::make('onlylaravel.padding.bottom')->label('Padding Bottom')->default($this->getPadding('bottom')),
                ])->extraAttributes(['style' => 'padding:4px;']);
        }

        if ($this->paddingXSettings) {
            $tabs[] = Tab::make('Horizontal')
                ->schema([
                    TextInput::make('onlylaravel.padding.x.padding')->label('Padding X')->numeric()->extraAttributes(['style' => 'padding:0;'])->default($this->getPadding('x.padding')),
                ]);
        } elseif ($this->paddingXResponsiveSettings) {
            $tabs[] = Tab::make('Horizontal')
                ->schema([
                    BlockResponsiveNumberField::make('onlylaravel.padding.x')->label('Padding X')->default($this->getPadding('x')),
                ])->extraAttributes(['style' => 'padding:4px;']);
        }

        if ($this->paddingYSettings) {
            $tabs[] = Tab::make('Vertical')
                ->schema([
                    TextInput::make('onlylaravel.padding.y.padding')->label('Padding Y')->numeric()->extraAttributes(['style' => 'padding:0;'])->default($this->getPadding('y.padding')),
                ]);
        } elseif ($this->paddingYResponsiveSettings) {
            $tabs[] = Tab::make('Vertical')
                ->schema([
                    BlockResponsiveNumberField::make('onlylaravel.padding.y')->label('Padding Y')->default($this->getPadding('y')),
                ])->extraAttributes(['style' => 'padding:4px;']);
        }

        return $tabs;
    }

    public function hasPaddingSettingsEnabled()
    {
        return $this->paddingSettings || $this->paddingResponsiveSettings || $this->paddingLeftSettings || $this->paddingLeftResponsiveSettings
            || $this->paddingRightSettings || $this->paddingRightResponsiveSettings || $this->paddingTopSettings || $this->paddingTopResponsiveSettings
            || $this->paddingBottomSettings || $this->paddingBottomResponsiveSettings;
    }

    public function padding($padding = 0)
    {
        $this->paddingSettings = true;
        Arr::set($this->settings, 'onlylaravel.padding.padding', $padding);

        return $this;
    }

    public function responsivePadding($padding = 0, $small = 0, $medium = 0, $large = 0, $extra_large = 0, $two_extra_large = 0)
    {
        $this->paddingResponsiveSettings = true;
        Arr::set($this->settings, 'onlylaravel.padding', [
            'padding' => $padding,
            'small' => $small,
            'medium' => $medium,
            'large' => $large,
            'extra_large' => $extra_large,
            '2_extra_large' => $two_extra_large,
        ]);

        return $this;
    }

    public function paddingLeft($padding = 0)
    {
        $this->paddingLeftSettings = true;
        Arr::set($this->settings, 'onlylaravel.padding.left.padding', $padding);

        return $this;
    }

    public function responsivePaddingLeft($padding = 0, $small = 0, $medium = 0, $large = 0, $extra_large = 0, $two_extra_large = 0)
    {
        $this->paddingLeftResponsiveSettings = true;
        Arr::set($this->settings, 'onlylaravel.padding.left', [
            'padding' => $padding,
            'small' => $small,
            'medium' => $medium,
            'large' => $large,
            'extra_large' => $extra_large,
            '2_extra_large' => $two_extra_large,
        ]);

        return $this;
    }

    public function paddingRight($padding = 0)
    {
        $this->paddingRightSettings = true;
        Arr::set($this->settings, 'onlylaravel.padding.right.padding', $padding);

        return $this;
    }

    public function responsivePaddingRight($padding = 0, $small = 0, $medium = 0, $large = 0, $extra_large = 0, $two_extra_large = 0)
    {
        $this->paddingRightResponsiveSettings = true;
        Arr::set($this->settings, 'onlylaravel.padding.right', [
            'padding' => $padding,
            'small' => $small,
            'medium' => $medium,
            'large' => $large,
            'extra_large' => $extra_large,
            '2_extra_large' => $two_extra_large,
        ]);

        return $this;
    }

    public function paddingTop($padding = 0)
    {
        $this->paddingTopSettings = true;
        Arr::set($this->settings, 'onlylaravel.padding.top.padding', $padding);

        return $this;
    }

    public function responsivePaddingTop($padding = 0, $small = 0, $medium = 0, $large = 0, $extra_large = 0, $two_extra_large = 0)
    {
        $this->paddingTopResponsiveSettings = true;
        Arr::set($this->settings, 'onlylaravel.padding.top', [
            'padding' => $padding,
            'small' => $small,
            'medium' => $medium,
            'large' => $large,
            'extra_large' => $extra_large,
            '2_extra_large' => $two_extra_large,
        ]);

        return $this;
    }

    public function paddingBottom($padding = 0)
    {
        $this->paddingBottomSettings = true;
        Arr::set($this->settings, 'onlylaravel.padding.bottom.padding', $padding);

        return $this;
    }

    public function responsivePaddingBottom($padding = 0, $small = 0, $medium = 0, $large = 0, $extra_large = 0, $two_extra_large = 0)
    {
        $this->paddingBottomResponsiveSettings = true;
        Arr::set($this->settings, 'onlylaravel.padding.bottom', [
            'padding' => $padding,
            'small' => $small,
            'medium' => $medium,
            'large' => $large,
            'extra_large' => $extra_large,
            '2_extra_large' => $two_extra_large,
        ]);

        return $this;
    }

    public function paddingX($padding = 0)
    {
        $this->paddingXSettings = true;
        Arr::set($this->settings, 'onlylaravel.padding.x.padding', $padding);

        return $this;
    }

    public function responsivePaddingX($padding = 0, $small = 0, $medium = 0, $large = 0, $extra_large = 0, $two_extra_large = 0)
    {
        $this->paddingXResponsiveSettings = true;
        Arr::set($this->settings, 'onlylaravel.padding.x', [
            'padding' => $padding,
            'small' => $small,
            'medium' => $medium,
            'large' => $large,
            'extra_large' => $extra_large,
            '2_extra_large' => $two_extra_large,
        ]);

        return $this;
    }

    public function paddingY($padding = 0)
    {
        $this->paddingYSettings = true;
        Arr::set($this->settings, 'onlylaravel.padding.y.padding', $padding);

        return $this;
    }

    public function responsivePaddingY($padding = 0, $small = 0, $medium = 0, $large = 0, $extra_large = 0, $two_extra_large = 0)
    {
        $this->paddingYResponsiveSettings = true;
        Arr::set($this->settings, 'onlylaravel.padding.y', [
            'padding' => $padding,
            'small' => $small,
            'medium' => $medium,
            'large' => $large,
            'extra_large' => $extra_large,
            '2_extra_large' => $two_extra_large,
        ]);

        return $this;
    }

    public function enablePaddingSettingOnly(array|string $setting = 'paddingSettings')
    {
        $this->paddingSettings = false;
        $this->paddingResponsiveSettings = false;
        $this->paddingLeftSettings = false;
        $this->paddingLeftResponsiveSettings = false;
        $this->paddingRightSettings = false;
        $this->paddingRightResponsiveSettings = false;
        $this->paddingTopSettings = false;
        $this->paddingTopResponsiveSettings = false;
        $this->paddingBottomSettings = false;
        $this->paddingBottomResponsiveSettings = false;

        if (is_array($setting)) {
            foreach ($setting as $s) {
                $this->{$s} = true;
            }

            return;
        }

        $this->{$setting} = true;
    }

    public function getResponsivePaddingStyles($className, $setting = 'paddingAll')
    {
        $responsivePadding = $this->getPadding($setting);

        if (is_array($responsivePadding) && array_key_exists('padding', $responsivePadding)) {
            $styles = $this->generatePaddingStyles($className, $responsivePadding, 'padding');

            return $styles;
        }
    }

    public function getResponsivePaddingLeftStyles($className, $setting = 'left')
    {
        $responsivePaddingLeft = $this->getPadding($setting);

        if (is_array($responsivePaddingLeft) && array_key_exists('padding', $responsivePaddingLeft)) {
            $styles = $this->generatePaddingStyles($className, $responsivePaddingLeft, 'padding-left');

            return $styles;
        }
    }

    public function getResponsivePaddingRightStyles($className, $setting = 'right')
    {
        $responsivePaddingRight = $this->getPadding($setting);

        if (is_array($responsivePaddingRight) && array_key_exists('padding', $responsivePaddingRight)) {
            $styles = $this->generatePaddingStyles($className, $responsivePaddingRight, 'padding-right');

            return $styles;
        }
    }

    public function getResponsivePaddingTopStyles($className, $setting = 'top')
    {
        $responsivePaddingTop = $this->getPadding($setting);

        if (is_array($responsivePaddingTop) && array_key_exists('padding', $responsivePaddingTop)) {
            $styles = $this->generatePaddingStyles($className, $responsivePaddingTop, 'padding-top');

            return $styles;
        }
    }

    public function getResponsivePaddingBottomStyles($className, $setting = 'bottom')
    {
        $responsivePaddingBottom = $this->getPadding($setting);

        if (is_array($responsivePaddingBottom) && array_key_exists('padding', $responsivePaddingBottom)) {
            $styles = $this->generatePaddingStyles($className, $responsivePaddingBottom, 'padding-bottom');

            return $styles;
        }
    }

    public function getResponsivePaddingXStyles($className, $setting = 'x')
    {
        $responsivePaddingX = $this->getPadding($setting);

        if (is_array($responsivePaddingX) && array_key_exists('padding', $responsivePaddingX)) {
            $styles = $this->generatePaddingStyles($className, $responsivePaddingX, 'padding-left');
            $styles .= $this->generatePaddingStyles($className, $responsivePaddingX, 'padding-right');

            return $styles;
        }
    }

    public function getResponsivePaddingYStyles($className, $setting = 'y')
    {
        $responsivePaddingY = $this->getPadding($setting);

        if (is_array($responsivePaddingY) && array_key_exists('padding', $responsivePaddingY)) {
            $styles = $this->generatePaddingStyles($className, $responsivePaddingY, 'padding-top');
            $styles .= $this->generatePaddingStyles($className, $responsivePaddingY, 'padding-bottom');

            return $styles;
        }
    }

    private function generatePaddingStyles($className, $responsivePadding, $property)
    {
        $breakpoints = [
            'small' => '@media (min-width: 640px)',
            'medium' => '@media (min-width: 768px)',
            'large' => '@media (min-width: 1024px)',
            'extra_large' => '@media (min-width: 1280px)',
            '2_extra_large' => '@media (min-width: 1536px)',
        ];

        $styles = [];

        $styles[] = ".$className {";
        $styles[] = "$property: ".($responsivePadding['padding'] ?? '0').'rem;';
        $styles[] = '} ';

        foreach ($breakpoints as $size => $media) {
            if (isset($responsivePadding[$size])) {
                $styles[] = $media ? "$media {" : '';
                $styles[] = ".$className {";
                $styles[] = "$property: ".$responsivePadding[$size].'rem;';
                $styles[] = '} ';
                $styles[] = $media ? '} ' : '';
            }
        }

        return implode('', $styles);
    }
}
