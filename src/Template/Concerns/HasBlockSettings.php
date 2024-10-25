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

    public function setBlockSettings($settings)
    {
        return $this;
    }

    public function setSettings($settings)
    {
        $this->setBlockSettings($settings);

        if (is_array($settings)) {
            foreach ($settings as $key => $value) {
                Arr::set($this->settings, $key, $value);
            }
        }

        return $this;
    }

    public function getSettingFields()
    {
        return array_merge($this->getBlockSettings(), $this->settingFields);
    }

    public function storeDefaultSettingsToDatabase()
    {
        foreach ($this->getSettingFields() as $field) {
            if ($field->hasDefault()) {
                $blockSettings = $this->model->settings ?? [];

                $this->model->update([
                    'settings' => $this->setSettingValue($blockSettings, $field->getName(), $field->getDefault()),
                ]);
            }
        }
    }

    public function setSettingValue(array $settings, string $name, string | array $value)
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
        return count($this->getSettingFields()) > 0;
    }

    public function getSettingsTabsData()
    {
        $data = [];

        if ($this->hasSettings()) {
            $data[] = [
                'name' => 'settings',
                'label' => 'Settings',
            ];
        }

        if ($this->checkSettingsEnabled('customStyle')) {
            $data[] = [
                'name' => 'customstyle',
                'label' => 'Custom Style',
            ];
        }

        return $data;
    }

    public function checkSettingsEnabled($name)
    {
        if (method_exists($this, 'has'.ucfirst($name).'SettingsEnabled') && $this->{'has'.ucfirst($name).'SettingsEnabled'}()) {
            return true;
        }
        return false;
    }

}