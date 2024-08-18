<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

use Illuminate\Support\Arr;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ColorPicker;

trait HasTemplateSettings
{
    public $settings = [];

    protected $settingFields = [];

    public function settings($settingFields)
    {
        $this->settingFields = $settingFields;
        return $this;
    }

    public function getTemplateSettings()
    {
        return [];
    }

    public function setTemplateSettings($settings)
    {
        $this->settings = $settings;
        
        return $this;
    }

    public function getSettingFields()
    {
        return array_merge($this->getTemplateSettings(), $this->settingFields);
    }

    public function getMaxWidthSettingFields()
    {
        return [
            TextInput::make('maxwidth.mobile')->label('Mobile')->numeric()->suffix('%'),
            TextInput::make('maxwidth.tablet')->label('Tablet')->numeric()->suffix('px'),
            TextInput::make('maxwidth.tablet_wide')->label('Tablet Wide')->numeric()->suffix('px'),
            TextInput::make('maxwidth.laptop')->label('Laptop')->numeric()->suffix('px'),
            TextInput::make('maxwidth.desktop')->label('Desktop')->numeric()->suffix('px'),
            TextInput::make('maxwidth.desktop_wide')->label('Desktop Wide')->numeric()->suffix('px'),
        ];
    }

    public function getSpaceSettingFields()
    {
        return [
            TextInput::make('spacing.mobile')->label('Mobile')->numeric()->suffix('rm'),
            TextInput::make('spacing.tablet')->label('Tablet')->numeric()->suffix('rm'),
            TextInput::make('spacing.tablet_wide')->label('Tablet Wide')->numeric()->suffix('rm'),
            TextInput::make('spacing.laptop')->label('Laptop')->numeric()->suffix('rm'),
            TextInput::make('spacing.desktop')->label('Desktop')->numeric()->suffix('rm'),
            TextInput::make('spacing.desktop_wide')->label('Desktop Wide')->numeric()->suffix('rm'),
        ];
    }

    public function getColorSettingFields()
    {
        return [
            ColorPicker::make('color.background')->label('Background Color'),
            ColorPicker::make('color.text')->label('Text Color'),
        ];
    }

    public function getTextSettingFields()
    {
        $fields = [];

            $fields[] = Select::make('text.fontFamily')
            ->label('Font Family')->options(['normal' => 'Normal', 'italic' => 'Italic']);
            $fields[] = TextInput::make('text.fontSize')->label('Font Size')->numeric();
            $fields[] = TextInput::make('text.fontWeight')->label('Font Weight');
            $fields[] = Select::make('text.fontStyle')->label('Font Style')->options(['normal' => 'Normal', 'italic' => 'Italic']);
            $fields[] = TextInput::make('text.latterSpacing')->label('Latter Spacing')->numeric();
            $fields[] = TextInput::make('text.lineHeight')->label('Line Height')->numeric();
        
        return $fields;
    }

    public function storeDefaultSettingsToDatabase()
    {
        // dd($this->getSettingFields());
        foreach ($this->getSettingFields() as $field) {
            if ($field instanceof Field && $field->getDefaultState() && $this->hasModel()) {

                $blockSettings = $this->model->settings ?? [];
                $this->model->update([
                    'settings' => array_merge($blockSettings, $this->setSettingValue($blockSettings, $field->getName(), $field->getDefaultState())),
                ]);
            }

            if ($field instanceof Component && $field->hasChildComponentContainer()) {
                $fileds = $field->getChildComponents();

                foreach ($fileds as $filed) {
                    if ($filed instanceof Field && $filed->getDefaultState() && $this->hasModel()) {
                        
                        $blockSettings = $this->model->settings ?? [];

                        $this->model->update([
                            'settings' => $this->setSettingValue($blockSettings, $filed->getName(), $filed->getDefaultState()),
                        ]);
                    }
                }
            }
        }
    }

    public function setSettingValue(array $settings, string $name, string $value)
    {
        if (strpos($name, '.') !== false) {
            Arr::set($settings, $name, $value);
        } else {
            $settings[$name] = $value;
        }
        return $settings;
    }

    public function hasSettings()
    {
        return count($this->getSettingFields()) > 0;
    }

    public function getTemplateSetting(string $name)
    {
        return Arr::get($this->settings, $name) ?? null;
    }

}