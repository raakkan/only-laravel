<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

use Filament\Forms\Get;
use Illuminate\Support\Arr;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ColorPicker;
use Raakkan\OnlyLaravel\Facades\FontManager;

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
        if (is_array($settings)) {
            $this->settings = $settings;
            $this->setMaxWidthSettings($settings);
        }
        
        return $this;
    }

    public function getSettingFields()
    {
        return array_merge($this->getTemplateSettings(), $this->settingFields);
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
            ->label('Font Family')->options(collect(FontManager::getFontFamilies())->mapWithKeys(function ($value, $key) {
                return [$value['value'] => $value['name']];
            })->toArray());
            $fields[] = TextInput::make('text.fontSize')->label('Font Size')->numeric();
        
        return $fields;
    }

    public function storeDefaultSettingsToDatabase()
    {
        $fields = array_merge($this->getSettingFields(), $this->getSpaceSettingFields(), $this->getColorSettingFields(), $this->getTextSettingFields(), $this->getMaxWidthSettingFields());
        foreach ($fields as $field) {
            if ($field instanceof Field && $this->hasFieldDefaultValue($field) && $this->hasModel()) {

                $blockSettings = $this->model->settings ?? [];
                $this->model->update([
                    'settings' => array_merge($blockSettings, $this->setSettingValue($blockSettings, $field->getName(), $field->getDefaultState())),
                ]);
            }

            if ($field instanceof Component && $field->hasChildComponentContainer()) {
                $fileds = $field->getChildComponents();

                foreach ($fileds as $filed) {
                    if ($filed instanceof Field && $this->hasFieldDefaultValue($filed) && $this->hasModel()) {
                        
                        $blockSettings = $this->model->settings ?? [];

                        $this->model->update([
                            'settings' => $this->setSettingValue($blockSettings, $filed->getName(), $filed->getDefaultState()),
                        ]);
                    }
                }
            }
        }
        return $this;
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

    public function hasFieldDefaultValue($field)
    {
        try {
            return $field->getDefaultState() && $field->getDefaultState()!== null;
        } catch (\Throwable $th) {
            return false;
        }
    }

}