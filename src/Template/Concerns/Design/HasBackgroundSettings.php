<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Actions\Action;
use Raakkan\OnlyLaravel\Template\Enums\BackgroundType;
use Raakkan\OnlyLaravel\Template\Enums\BackgroundColorType;

trait HasBackgroundSettings
{
    protected $backgroundSettings = true;
    protected $backgroundType = BackgroundType::BOTH;

    public function getBackgroundSettingFields()
    {
        $fields = [];
        
        if ($this->backgroundType === BackgroundType::COLOR || $this->backgroundType === BackgroundType::BOTH) {
            $fields = array_merge(
                $fields,
                $this->getBackgroundColorTypeFields(),
                $this->getBackgroundColorFields(),
                $this->getBackgroundGradientFields()
            );
        }

        if ($this->backgroundType === BackgroundType::IMAGE || $this->backgroundType === BackgroundType::BOTH) {
            $fields = array_merge($fields, $this->getBackgroundImageFields());
        }

        return $fields;
    }

    public function getBackgroundColorType()
    {
        return Arr::get($this->settings, 'onlylaravel.background.color_type', 'color');
    }

    public function getBackgroundColor()
    {
        return Arr::get($this->settings, 'onlylaravel.background.color', '#ffffff');
    }

    public function getBackgroundGradientDirection()
    {
        return Arr::get($this->settings, 'onlylaravel.background.gradient_direction', 'to right');
    }

    public function getBackgroundGradientFrom()
    {
        return Arr::get($this->settings, 'onlylaravel.background.gradient.from', '#ffffff');
    }
    
    public function getBackgroundGradientTo()
    {
        return Arr::get($this->settings, 'onlylaravel.background.gradient.to', '#000000');
    }

    public function getBackgroundImage()
    {
        return Arr::get($this->settings, 'onlylaravel.background.image', '');
    }

    public function getBackgroundColorDark()
    {
        return Arr::get($this->settings, 'onlylaravel.background.color_dark', '#000000');
    }

    public function hasBackgroundSettingsEnabled()
    {
        return $this->backgroundSettings;
    }

    public function backgroundColor($color, $darkColor = null)
    {
        $this->backgroundType = BackgroundType::COLOR;
        $this->backgroundSettings = true;
        Arr::set($this->settings, 'onlylaravel.background.color_type', 'color');
        Arr::set($this->settings, 'onlylaravel.background.color', $color);
        if ($darkColor) {
            Arr::set($this->settings, 'onlylaravel.background.color_dark', $darkColor);
        }
        return $this;
    }

    public function backgroundGradient($direction, $from, $to)
    {
        $this->backgroundType = BackgroundType::COLOR;
        $this->backgroundSettings = true;
        Arr::set($this->settings, 'onlylaravel.background.color_type', 'gradient');
        Arr::set($this->settings, 'onlylaravel.background.gradient_direction', $direction);
        Arr::set($this->settings, 'onlylaravel.background.gradient.from', $from);
        Arr::set($this->settings, 'onlylaravel.background.gradient.to', $to);
        return $this;
    }

    public function backgroundImage($image)
    {
        $this->backgroundType = BackgroundType::IMAGE;
        $this->backgroundSettings = true;
        Arr::set($this->settings, 'onlylaravel.background.image', $image);
        return $this;
    }

    public function getBackgroundStyles()
    {
        $styles = [];

        if ($this->backgroundType === BackgroundType::COLOR || $this->backgroundType === BackgroundType::BOTH) {
            $colorType = $this->getBackgroundColorType();
            
            if ($colorType === 'color') {
                $backgroundColor = $this->getBackgroundColor();
                $backgroundColorDark = $this->getBackgroundColorDark();

                if ($backgroundColor) {
                    $styles[] = ".bg-{$this->getName()} { background-color: {$backgroundColor} }";
                }

                if ($backgroundColorDark) {
                    $styles[] = ".dark\\:bg-{$this->getName()}:where(.dark, .dark *) { background-color: {$backgroundColorDark} }";
                }
            } elseif ($colorType === 'gradient') {
                $direction = $this->getBackgroundGradientDirection();
                $from = $this->getBackgroundGradientFrom();
                $to = $this->getBackgroundGradientTo();

                if ($from && $to) {
                    $styles[] = ".bg-{$this->getName()} { background-image: linear-gradient({$direction}, {$from}, {$to}) }";
                }
            }
        }

        return implode("\n", $styles);
    }

    public function getBackgroundClasses()
    {
        $classes = [];

        if ($this->backgroundType === BackgroundType::COLOR || $this->backgroundType === BackgroundType::BOTH) {
            $classes[] = "bg-{$this->getName()}";
            $classes[] = "dark:bg-{$this->getName()}";
        }

        return implode(' ', $classes);
    }

    public function getBackgroundImageStyles()
    {
        $backgroundImage = $this->getBackgroundImage();

        if ($backgroundImage && File::exists(storage_path('app/public/' . $backgroundImage))) {
            $imageUrl = url(Storage::url($backgroundImage));
            return " background-image: url('{$imageUrl}'); background-size: cover; background-position: center; background-repeat: no-repeat;";
        }
        return '';
    }

    public function getBackgroundColorTypeFields()
    {
        return [
            Select::make('onlylaravel.background.color_type')
            ->label('Background Color Type')
            ->options([
                'color' => 'Color',
                'gradient' => 'Gradient',
            ])
            ->required()
            ->live(onBlur: true)
            ->default($this->getBackgroundColorType())
            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('onlylaravel.background.color', $state == 'color' ? '#000000' : ''))
        ];
    }

    public function getBackgroundColorFields()
    {
        return [
            ColorPicker::make('onlylaravel.background.color')
                    ->label('Background Color')
                    ->default($this->getBackgroundColor())
                    ->hintAction(
                        Action::make('clear')
                            ->label('Clear')
                            ->icon('heroicon-m-x-circle')
                            ->action(function (Set $set) {
                                $set('onlylaravel.background.color', '');
                            })
                    )->rgba()
                    ->visible(fn (Get $get) => $get('onlylaravel.background.color_type') == 'color'),
            ColorPicker::make('onlylaravel.background.color_dark')->label('Background Color (Dark)')
                ->default($this->getBackgroundColorDark())->rgba()
                ->hintAction(
                    Action::make('clear')
                        ->label('Clear')
                        ->icon('heroicon-m-x-circle')
                        ->action(function (Set $set) {
                            $set('onlylaravel.background.color_dark', '');
                        })
                )->visible(fn (Get $get) => $get('onlylaravel.background.color_type') == 'color'),
        ];
    }

    public function getBackgroundGradientFields()
    {
        return [
            Select::make('onlylaravel.background.gradient_direction')
            ->label('Gradient Direction')
            ->options([
                'to right' => 'To Right',
                'to left' => 'To Left',
                'to top' => 'To Top',
                'to bottom' => 'To Bottom',
                'to top right' => 'To Top Right',
                'to bottom right' => 'To Bottom Right',
                'to top left' => 'To Top Left',
                'to bottom left' => 'To Bottom Left',
            ])
            ->visible(fn (Get $get) => $get('onlylaravel.background.color_type') == 'gradient')
            ->default($this->getBackgroundGradientDirection())
            ->hintAction(
                Action::make('clear')
                    ->label('Clear')
                    ->icon('heroicon-m-x-circle')
                    ->action(function (Set $set) {
                        $set('onlylaravel.background.gradient_direction', '');
                    })
            ),
            ColorPicker::make('onlylaravel.background.gradient.from')
            ->label('Gradient From')
            ->default($this->getBackgroundGradientFrom())
            ->rgba()
            ->hintAction(
                Action::make('clear')
                    ->label('Clear')
                    ->icon('heroicon-m-x-circle')
                    ->action(function (Set $set) {
                        $set('onlylaravel.background.gradient.from', '');
                    })
            )->visible(fn (Get $get) => $get('onlylaravel.background.color_type') == 'gradient'),
        ColorPicker::make('onlylaravel.background.gradient.to')
            ->label('Gradient To')
            ->default($this->getBackgroundGradientTo())
            ->rgba()
            ->hintAction(
                Action::make('clear')
                    ->label('Clear')    
                    ->icon('heroicon-m-x-circle')
                    ->action(function (Set $set) {
                        $set('onlylaravel.background.gradient.to', '');
                    })
            )->visible(fn (Get $get) => $get('onlylaravel.background.color_type') == 'gradient'),
        ];
    }

    public function getBackgroundImageFields()
    {
        return [
            FileUpload::make('onlylaravel.background.image')
            ->label('Background Image')
            ->image()
            ->storeFileNamesIn('attachment_file_names')
            ->directory('templates/backgrounds')
            ->default($this->getBackgroundImage())
            ->hintAction(
                Action::make('clear')
                    ->label('Clear')
                    ->icon('heroicon-m-x-circle')
                    ->action(function (Set $set) {
                        $set('onlylaravel.background.image', '');
                    })
            ),
        ];
    }
}
