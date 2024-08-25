<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Illuminate\Support\Arr;
use Filament\Forms\Components\TextInput;
use Raakkan\OnlyLaravel\Filament\Components\BlockResponsiveNumberField;

trait HasMarginSettings
{
    protected $marginSettings = false;
    protected $marginResponsiveSettings = false;
    protected $marginLeftSettings = false;
    protected $marginLeftResponsiveSettings = false;
    protected $marginRightSettings = false;
    protected $marginRightResponsiveSettings = false;
    protected $marginTopSettings = false;
    protected $marginTopResponsiveSettings = false;
    protected $marginBottomSettings = false;
    protected $marginBottomResponsiveSettings = false;

    public function getPadding($name = 'margin')
    {
        if ($name == 'marginAll') {
            return Arr::get($this->settings, 'onlylaravel.margin', []);
        }

        return Arr::get($this->settings, "onlylaravel.margin.$name");
    }

    public function getMarginSettingFields()
    {
        $fields = [];
        
        if ($this->marginSettings) {
            if ($this->marginResponsiveSettings) {
                $fields[] = BlockResponsiveNumberField::make('onlylaravel.margin')->label('Margin')->default($this->getMargin('marginAll'));
            } else {
                $fields[] = TextInput::make('onlylaravel.margin.margin')->label('Margin')->numeric()->extraAttributes(['style' => 'padding:0;'])->default($this->getMargin());
            };
        }

        if ($this->marginLeftSettings) {
            if ($this->marginLeftResponsiveSettings) {
                $fields[] = BlockResponsiveNumberField::make('onlylaravel.margin.left')->label('Margin Left')->default($this->getMargin('left'));
            } else {
                $fields[] = TextInput::make('onlylaravel.margin.left.margin')->label('Margin Left')->numeric()->extraAttributes(['style' => 'padding:0;'])->default($this->getMargin('left.margin'));
            };
        }

        if ($this->marginRightSettings) {
            if ($this->marginRightResponsiveSettings) {
                $fields[] = BlockResponsiveNumberField::make('onlylaravel.margin.right')->label('Margin Right')->default($this->getMargin('right'));
            } else {
                $fields[] = TextInput::make('onlylaravel.margin.right.margin')->label('Margin Right')->numeric()->extraAttributes(['style' => 'padding:0;'])->default($this->getMargin('right.margin'));
            };
        }

        if ($this->marginTopSettings) {
            if ($this->marginTopResponsiveSettings) {
                $fields[] = BlockResponsiveNumberField::make('onlylaravel.margin.top')->label('Margin Top')->default($this->getMargin('top'));
            } else {
                $fields[] = TextInput::make('onlylaravel.margin.top.margin')->label('Margin Top')->numeric()->extraAttributes(['style' => 'padding:0;'])->default($this->getMargin('top.margin'));
            };
        }

        if ($this->marginBottomSettings) {
            if ($this->marginBottomResponsiveSettings) {
                $fields[] = BlockResponsiveNumberField::make('onlylaravel.margin.bottom')->label('Margin Bottom')->default($this->getMargin('bottom'));
            } else {
                $fields[] = TextInput::make('onlylaravel.margin.bottom.margin')->label('Margin Bottom')->numeric()->extraAttributes(['style' => 'padding:0;'])->default($this->getMargin('bottom.margin'));
            };
        }
        return $fields;
    }

    public function hasMarginSettingsEnabled()
    {
        return $this->marginSettings || $this->marginLeftSettings || $this->marginRightSettings || $this->marginTopSettings || $this->marginBottomSettings;
    }

    public function margin($margin = 0)
    {
        $this->marginSettings = true;
        Arr::set($this->settings, 'onlylaravel.margin.margin', $margin);
        return $this;
    }

    public function responsiveMargin($margin = 0, $small = 0, $medium = 0, $large = 0, $extra_large = 0, $two_extra_large = 0)
    {
        $this->marginResponsiveSettings = true;
        Arr::set($this->settings, 'onlylaravel.margin', [
            'margin' => $margin,
            'small' => $small,
            'medium' => $medium,
            'large' => $large,
            'extra_large' => $extra_large,
            '2_extra_large' => $two_extra_large
        ]);
        
        return $this;
    }

    public function marginLeft($margin = 0)
    {
        $this->marginLeftSettings = true;
        Arr::set($this->settings, 'onlylaravel.margin.left.margin', $margin);
        return $this;
    }

    public function responsiveMarginLeft($margin = 0, $small = 0, $medium = 0, $large = 0, $extra_large = 0, $two_extra_large = 0)
    {
        $this->marginLeftResponsiveSettings = true;
        Arr::set($this->settings, 'onlylaravel.margin.left', [
            'margin' => $margin,
            'small' => $small,
            'medium' => $medium,
            'large' => $large,
            'extra_large' => $extra_large,
            '2_extra_large' => $two_extra_large
        ]);
        return $this;
    }

    public function marginRight($margin = 0)
    {
        $this->marginRightSettings = true;
        Arr::set($this->settings, 'onlylaravel.margin.right.margin', $margin);
        return $this;
    }

    public function responsiveMarginRight($margin = 0, $small = 0, $medium = 0, $large = 0, $extra_large = 0, $two_extra_large = 0)
    {
        $this->marginRightResponsiveSettings = true;
        Arr::set($this->settings, 'onlylaravel.margin.right', [
            'margin' => $margin,
            'small' => $small,
            'medium' => $medium,
            'large' => $large,
            'extra_large' => $extra_large,
            '2_extra_large' => $two_extra_large
        ]);
        return $this;
    }

    public function marginTop($margin = 0)
    {
        $this->marginTopSettings = true;
        Arr::set($this->settings, 'onlylaravel.margin.top.margin', $margin);
        return $this;
    }

    public function responsiveMarginTop($margin = 0, $small = 0, $medium = 0, $large = 0, $extra_large = 0, $two_extra_large = 0)
    {
        $this->marginTopResponsiveSettings = true;
        Arr::set($this->settings, 'onlylaravel.margin.top', [
            'margin' => $margin,
            'small' => $small,
            'medium' => $medium,
            'large' => $large,
            'extra_large' => $extra_large,
            '2_extra_large' => $two_extra_large
        ]);
        return $this;
    }

    public function marginBottom($margin = 0)
    {
        $this->marginBottomSettings = true;
        Arr::set($this->settings, 'onlylaravel.margin.bottom.margin', $margin);
        return $this;
    }

    public function responsiveMarginBottom($margin = 0, $small = 0, $medium = 0, $large = 0, $extra_large = 0, $two_extra_large = 0)
    {
        $this->marginBottomResponsiveSettings = true;
        Arr::set($this->settings, 'onlylaravel.margin.bottom', [
            'margin' => $margin,
            'small' => $small,
            'medium' => $medium,
            'large' => $large,
            'extra_large' => $extra_large,
            '2_extra_large' => $two_extra_large
        ]);
        return $this;
    }
}
