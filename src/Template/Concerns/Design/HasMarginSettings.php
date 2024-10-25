<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Arr;
use Raakkan\OnlyLaravel\Filament\Components\BlockResponsiveNumberField;

trait HasMarginSettings
{
    protected $marginSettings = true;

    protected $marginResponsiveSettings = true;

    protected $marginLeftSettings = true;

    protected $marginLeftResponsiveSettings = true;

    protected $marginRightSettings = true;

    protected $marginRightResponsiveSettings = true;

    protected $marginTopSettings = true;

    protected $marginTopResponsiveSettings = true;

    protected $marginBottomSettings = true;

    protected $marginBottomResponsiveSettings = true;

    public function getMargin($name = 'margin')
    {
        if ($name == 'marginAll') {
            return Arr::get($this->settings, 'onlylaravel.margin', []);
        }

        return Arr::get($this->settings, "onlylaravel.margin.$name");
    }

    public function getMarginSettingFields()
    {
        return [
            Tabs::make('Margin')
                ->tabs($this->getMarginFieldsTabs()),
        ];
    }

    public function getMarginFieldsTabs()
    {
        $tabs = [];

        if ($this->marginSettings) {
            $tabs[] = Tab::make('Margin')
                ->schema([
                    TextInput::make('onlylaravel.margin.margin')->label('Margin')->numeric()->extraAttributes(['style' => 'padding:0;'])->default($this->getMargin()),
                ]);
        } elseif ($this->marginResponsiveSettings) {
            $tabs[] = Tab::make('Margin')
                ->schema([
                    BlockResponsiveNumberField::make('onlylaravel.margin')->label('Margin')->default($this->getMargin('marginAll')),
                ])->extraAttributes(['style' => 'padding:4px;']);
        }

        if ($this->marginLeftSettings) {
            $tabs[] = Tab::make('Left')
                ->schema([
                    TextInput::make('onlylaravel.margin.left.margin')->label('Margin Left')->numeric()->extraAttributes(['style' => 'padding:0;'])->default($this->getMargin('left.margin')),
                ]);
        } elseif ($this->marginLeftResponsiveSettings) {
            $tabs[] = Tab::make('Left')
                ->schema([
                    BlockResponsiveNumberField::make('onlylaravel.margin.left')->label('Margin Left')->default($this->getMargin('left')),
                ])->extraAttributes(['style' => 'padding:4px;']);
        }

        if ($this->marginRightSettings) {
            $tabs[] = Tab::make('Right')
                ->schema([
                    TextInput::make('onlylaravel.margin.right.margin')->label('Margin Right')->numeric()->extraAttributes(['style' => 'padding:0;'])->default($this->getMargin('right.margin')),
                ]);
        } elseif ($this->marginRightResponsiveSettings) {
            $tabs[] = Tab::make('Right')
                ->schema([
                    BlockResponsiveNumberField::make('onlylaravel.margin.right')->label('Margin Right')->default($this->getMargin('right')),
                ])->extraAttributes(['style' => 'padding:4px;']);
        }

        if ($this->marginTopSettings) {
            $tabs[] = Tab::make('Top')
                ->schema([
                    TextInput::make('onlylaravel.margin.top.margin')->label('Margin Top')->numeric()->extraAttributes(['style' => 'padding:0;'])->default($this->getMargin('top.margin')),
                ]);
        } elseif ($this->marginTopResponsiveSettings) {
            $tabs[] = Tab::make('Top')
                ->schema([
                    BlockResponsiveNumberField::make('onlylaravel.margin.top')->label('Margin Top')->default($this->getMargin('top')),
                ])->extraAttributes(['style' => 'padding:4px;']);
        }

        if ($this->marginBottomSettings) {
            $tabs[] = Tab::make('Bottom')
                ->schema([
                    TextInput::make('onlylaravel.margin.bottom.margin')->label('Margin Bottom')->numeric()->extraAttributes(['style' => 'padding:0;'])->default($this->getMargin('bottom.margin')),
                ]);
        } elseif ($this->marginBottomResponsiveSettings) {
            $tabs[] = Tab::make('Bottom')
                ->schema([
                    BlockResponsiveNumberField::make('onlylaravel.margin.bottom')->label('Margin Bottom')->default($this->getMargin('bottom')),
                ])->extraAttributes(['style' => 'padding:4px;']);
        }

        return $tabs;
    }

    public function hasMarginSettingsEnabled()
    {
        return $this->marginSettings || $this->marginResponsiveSettings || $this->marginLeftSettings || $this->marginLeftResponsiveSettings
            || $this->marginRightSettings || $this->marginRightResponsiveSettings || $this->marginTopSettings || $this->marginTopResponsiveSettings
            || $this->marginBottomSettings || $this->marginBottomResponsiveSettings;
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
            '2_extra_large' => $two_extra_large,
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
            '2_extra_large' => $two_extra_large,
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
            '2_extra_large' => $two_extra_large,
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
            '2_extra_large' => $two_extra_large,
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
            '2_extra_large' => $two_extra_large,
        ]);

        return $this;
    }

    public function enableMarginSettingOnly(array|string $setting = 'marginSettings')
    {
        $this->marginSettings = false;
        $this->marginResponsiveSettings = false;
        $this->marginLeftSettings = false;
        $this->marginLeftResponsiveSettings = false;
        $this->marginRightSettings = false;
        $this->marginRightResponsiveSettings = false;
        $this->marginTopSettings = false;
        $this->marginTopResponsiveSettings = false;
        $this->marginBottomSettings = false;
        $this->marginBottomResponsiveSettings = false;

        if (is_array($setting)) {
            foreach ($setting as $s) {
                $this->{$s} = true;
            }

            return;
        }

        $this->{$setting} = true;
    }

    public function getResponsiveMarginStyles($className, $setting = 'marginAll')
    {
        $responsiveMargin = $this->getMargin($setting);

        if (is_array($responsiveMargin) && array_key_exists('margin', $responsiveMargin)) {
            $styles = $this->generateMarginStyles($className, $responsiveMargin, 'margin');

            return $styles;
        }
    }

    public function getResponsiveMarginLeftStyles($className, $setting = 'left')
    {
        $responsiveMarginLeft = $this->getMargin($setting);

        if (is_array($responsiveMarginLeft) && array_key_exists('margin', $responsiveMarginLeft)) {
            $styles = $this->generateMarginStyles($className, $responsiveMarginLeft, 'margin-left');

            return $styles;
        }
    }

    public function getResponsiveMarginRightStyles($className, $setting = 'right')
    {
        $responsiveMarginRight = $this->getMargin($setting);

        if (is_array($responsiveMarginRight) && array_key_exists('margin', $responsiveMarginRight)) {
            $styles = $this->generateMarginStyles($className, $responsiveMarginRight, 'margin-right');

            return $styles;
        }
    }

    public function getResponsiveMarginTopStyles($className, $setting = 'top')
    {
        $responsiveMarginTop = $this->getMargin($setting);

        if (is_array($responsiveMarginTop) && array_key_exists('margin', $responsiveMarginTop)) {
            $styles = $this->generateMarginStyles($className, $responsiveMarginTop, 'margin-top');

            return $styles;
        }
    }

    public function getResponsiveMarginBottomStyles($className, $setting = 'bottom')
    {
        $responsiveMarginBottom = $this->getMargin($setting);

        if (is_array($responsiveMarginBottom) && array_key_exists('margin', $responsiveMarginBottom)) {
            $styles = $this->generateMarginStyles($className, $responsiveMarginBottom, 'margin-bottom');

            return $styles;
        }
    }

    private function generateMarginStyles($className, $responsiveMargin, $property)
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
        $styles[] = "$property: ".($responsiveMargin['margin'] ?? '0').'rem;';
        $styles[] = '} ';

        foreach ($breakpoints as $size => $media) {
            if (isset($responsiveMargin[$size])) {
                $styles[] = $media ? "$media {" : '';
                $styles[] = ".$className {";
                $styles[] = "$property: ".$responsiveMargin[$size].'rem;';
                $styles[] = '} ';
                $styles[] = $media ? '} ' : '';
            }
        }

        return implode('', $styles);
    }
}
