<?php

namespace Raakkan\OnlyLaravel\Support\Concerns;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Field;
use Illuminate\Support\Arr;

trait HasSettings
{
    protected $settings = [];

    protected $settingFields = [];

    public function getSettings(): array
    {
        return $this->settings;
    }

    public function setSettings(array $settings): self
    {
        $this->settings = $settings;

        return $this;
    }

    public function settings(array $settingFields): self
    {
        $this->settingFields = $settingFields;

        return $this;
    }

    public function hasSettings(): bool
    {
        return count($this->settings) > 0;
    }

    public function getSettingFields(): array
    {
        return $this->settingFields;
    }

    public function hasSettingFields(): bool
    {
        return count($this->settingFields) > 0;
    }

    public function setSettingFields(array $settingFields): self
    {
        $this->settingFields = $settingFields;

        return $this;
    }

    public function storeDefaultSettingsToDatabase()
    {
        $fields = $this->getSettingFields();
        foreach ($fields as $field) {
            if ($field instanceof Field && $this->hasFieldDefaultValue($field) && method_exists($this, 'hasModel') && $this->hasModel()) {

                $blockSettings = $this->model->settings ?? [];
                $this->model->update([
                    'settings' => array_merge($blockSettings, $this->setSettingValue($blockSettings, $field->getName(), $field->getDefaultState())),
                ]);
            }

            if ($field instanceof Component && $field->hasChildComponentContainer()) {
                $fileds = $field->getChildComponents();

                foreach ($fileds as $filed) {
                    if ($filed instanceof Field && $this->hasFieldDefaultValue($filed) && method_exists($this, 'hasModel') && $this->hasModel()) {

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

    public function hasFieldDefaultValue($field)
    {
        try {
            return $field->getDefaultState() && $field->getDefaultState() !== null;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
