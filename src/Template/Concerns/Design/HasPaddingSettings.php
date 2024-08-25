<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Illuminate\Support\Arr;
use Filament\Forms\Components\TextInput;
use Raakkan\OnlyLaravel\Filament\Components\BlockResponsiveNumberField;

trait HasPaddingSettings
{
    protected $paddingSettings = false;
    protected $paddingResponsiveSettings = false;
    protected $paddingLeftSettings = false;
    protected $paddingLeftResponsiveSettings = false;
    protected $paddingRightSettings = false;
    protected $paddingRightResponsiveSettings = false;
    protected $paddingTopSettings = false;
    protected $paddingTopResponsiveSettings = false;
    protected $paddingBottomSettings = false;
    protected $paddingBottomResponsiveSettings = false;

    public function getPadding($name = 'padding')
    {
        if ($name == 'paddingAll') {
            return Arr::get($this->settings, 'onlylaravel.padding', []);
        }

        return Arr::get($this->settings, "onlylaravel.padding.$name");
    }

    public function getPaddingSettingFields()
    {
        $fields = [];
        
        if ($this->paddingSettings) {
            if ($this->paddingResponsiveSettings) {
                $fields[] = BlockResponsiveNumberField::make('onlylaravel.padding')->label('Padding')->default($this->getPadding('paddingAll'));
            } else {
                $fields[] = TextInput::make('onlylaravel.padding.padding')->label('Padding')->numeric()->extraAttributes(['style' => 'padding:0;'])->default($this->getPadding());
            };
        }

        if ($this->paddingLeftSettings) {
            if ($this->paddingLeftResponsiveSettings) {
                $fields[] = BlockResponsiveNumberField::make('onlylaravel.padding.left')->label('Padding Left')->default($this->getPadding('left'));
            } else {
                $fields[] = TextInput::make('onlylaravel.padding.left.padding')->label('Padding Left')->numeric()->extraAttributes(['style' => 'padding:0;'])->default($this->getPadding('left.padding'));
            };
        }

        if ($this->paddingRightSettings) {
            if ($this->paddingRightResponsiveSettings) {
                $fields[] = BlockResponsiveNumberField::make('onlylaravel.padding.right')->label('Padding Right')->default($this->getPadding('right'));
            } else {
                $fields[] = TextInput::make('onlylaravel.padding.right.padding')->label('Padding Right')->numeric()->extraAttributes(['style' => 'padding:0;'])->default($this->getPadding('right.padding'));
            };
        }

        if ($this->paddingTopSettings) {
            if ($this->paddingTopResponsiveSettings) {
                $fields[] = BlockResponsiveNumberField::make('onlylaravel.padding.top')->label('Padding Top');
            } else {
                $fields[] = TextInput::make('onlylaravel.padding.top.padding')->label('Padding Top')->numeric()->extraAttributes(['style' => 'padding:0;'])->default($this->getPadding('top.padding'));
            };
        }

        if ($this->paddingBottomSettings) {
            if ($this->paddingBottomResponsiveSettings) {
                $fields[] = BlockResponsiveNumberField::make('onlylaravel.padding.bottom')->label('Padding Bottom')->default($this->getPadding('bottom'));
            } else {
                $fields[] = TextInput::make('onlylaravel.padding.bottom.padding')->label('Padding Bottom')->numeric()->extraAttributes(['style' => 'padding:0;'])->default($this->getPadding('bottom.padding'));
            };
        }
        return $fields;
    }

    public function hasPaddingSettingsEnabled()
    {
        return $this->paddingSettings || $this->paddingLeftSettings || $this->paddingRightSettings || $this->paddingTopSettings || $this->paddingBottomSettings;
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
            '2_extra_large' => $two_extra_large
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
            '2_extra_large' => $two_extra_large
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
            '2_extra_large' => $two_extra_large
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
            '2_extra_large' => $two_extra_large
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
            '2_extra_large' => $two_extra_large
        ]);
        return $this;
    }
}
