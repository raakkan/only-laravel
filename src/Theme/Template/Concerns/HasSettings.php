<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Concerns;

use Illuminate\Support\Arr;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Component;

trait HasSettings
{
    protected $settingFields = [];

    public function settings($settingFields)
    {
        $this->settingFields = $settingFields;
        return $this;
    }

    public function getSettingFields()
    {
        if ($this->backgroundSettingsEnabled()) {
            return array_merge($this->getBackgroundSettings(), $this->settingFields);
        }

        return $this->settingFields;
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