<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

use Illuminate\Support\Arr;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Component;

trait HasBlockSettings
{
    public $settings = [];

    protected $settingFields = [];

    public function settings($settingFields)
    {
        $this->settingFields = $settingFields;
        return $this;
    }

    public function getBlockSettings()
    {
        return [];
    }

    public function getBlockCustomSettings()
    {
        return [];
    }

    public function setBlockCustomSettings($settings)
    {
        return $this;
    }

    public function setBlockSettings($settings)
    {
        if (is_array($settings) && array_key_exists('design_variant', $settings) && $this->type == 'component') {
            $this->setDesignVariant($settings);
        }

        if (is_array($settings) && array_key_exists('color', $settings) && $this->hasColorSettingsEnabled()) {
            $this->setColorSettings($settings);
        }

        if (is_array($settings) && array_key_exists('text', $settings) && $this->hasTextSettingsEnabled()) {
            $this->setTextSettings($settings);
        }

        $this->setBlockCustomSettings($settings);

        $this->settings = $settings;

        return $this;
    }

    public function getSettingFields($includeAll = false)
    {
        $settingsFields = array_merge($this->getBlockSettings(), $this->settingFields, $this->getBlockCustomSettings());

        if ($includeAll) {
            if ($this->hasColorSettingsEnabled()) {
                $settingsFields = array_merge($settingsFields, $this->getColorSettingFields());
            }
    
            if ($this->hasTextSettingsEnabled()) {
                $settingsFields = array_merge($settingsFields, $this->getTextSettingFields());
            }

            
        }

        if ($this->type == 'component' && method_exists($this, 'hasDesignVariants') && $this->hasDesignVariants()) {
            $settingsFields = array_merge($settingsFields, $this->getDesignVariantSettings());
        }

        return $settingsFields;
    }

    public function storeDefaultSettingsToDatabase()
    {
        // dd($this->getSettingFields());
        foreach ($this->getSettingFields(true) as $field) {
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

    public function hasAnySettings()
    {
        return count($this->getSettingFields(true)) > 0;
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