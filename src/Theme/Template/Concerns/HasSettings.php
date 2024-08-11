<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Concerns;

use Illuminate\Support\Arr;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Component;

trait HasSettings
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

    public function setBlockSettings($settings)
    {
        if (is_array($settings) && array_key_exists('design_variant', $settings) && $this->type == 'component') {
            $designVariant = Arr::pull($settings, 'design_variant');
            $this->setDesignVariant($designVariant);
        }

        if (is_array($settings) && array_key_exists('background', $settings) && $this->backgroundSettingsEnabled()) {
            $this->setBackground($settings['background']);
        }

        $this->settings = $settings;
    }

    public function getSettingFields()
    {
        $settingsFields = array_merge($this->settingFields, $this->getBlockSettings());

        if ($this->backgroundSettingsEnabled()) {
            $settingsFields = array_merge($settingsFields, $this->getBackgroundSettings());
        }

        if ($this->type == 'component' && $this->hasDesignVariants()) {
            $settingsFields = array_merge($settingsFields, $this->getDesignVariantSettings());
        }

        return $settingsFields;
    }

    public function storeDefaultSettingsToDatabase()
    {
        foreach ($this->getSettingFields() as $field) {
            if ($field instanceof Field && $field->getDefaultState() && $this->hasModel()) {

                $blockSettings = $this->model->settings ?? [];
                $this->model->update([
                    'settings' => array_merge($blockSettings, $this->setSettingValue($blockSettings, $filed->getName(), $filed->getDefaultState())),
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

}