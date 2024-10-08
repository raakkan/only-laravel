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
        if (is_array($settings) && array_key_exists('onlylaravel', $settings)) {
            $onlylaravel = $settings['onlylaravel'];
            
            if (array_key_exists('design_variant', $onlylaravel) && $this->type == 'component') {
               $this->designVariant = $onlylaravel['design_variant'];
            }
        }

        $this->setBlockSettings($settings);

        // Check if $settings is an array before iterating
        if (is_array($settings)) {
            foreach ($settings as $key => $value) {
                Arr::set($this->settings, $key, $value);
            }
        }

        return $this;
    }

    public function getSettingFields($includeAll = false)
    {
        $settingsFields = array_merge($this->getBlockSettings(), $this->settingFields);

        if ($includeAll) {
            if ($this->checkSettingsEnabled('background')) {
                $settingsFields = array_merge($settingsFields, $this->getBackgroundSettingFields());
            }
    
            if ($this->checkSettingsEnabled('text')) {
                $settingsFields = array_merge($settingsFields, $this->getTextSettingFields());
            }

            if ($this->checkSettingsEnabled('padding')) {
                $settingsFields = array_merge($settingsFields, $this->getPaddingSettingFields());
            }

            if ($this->checkSettingsEnabled('customStyle')) {
                $settingsFields = array_merge($settingsFields, $this->getCustomStyleSettingFields());
            }

            if ($this->checkSettingsEnabled('margin')) {
                $settingsFields = array_merge($settingsFields, $this->getMarginSettingFields());
            }

            if ($this->checkSettingsEnabled('width')) {
                $settingsFields = array_merge($settingsFields, $this->getWidthSettingFields());
            }

            if ($this->checkSettingsEnabled('height')) {
                $settingsFields = array_merge($settingsFields, $this->getHeightSettingFields());
            }
            
            if ($this->checkSettingsEnabled('border')) {
                $settingsFields = array_merge($settingsFields, $this->getBorderSettingFields());
            }

            if ($this->checkSettingsEnabled('customAttribute')) {
                $settingsFields = array_merge($settingsFields, $this->getCustomAttributeSettingFields());
            }
        }

        if ($this->type == 'component' && method_exists($this, 'hasDesignVariants') && $this->hasDesignVariants()) {
            $settingsFields = array_merge($settingsFields, $this->getDesignVariantSettings());
        }

        return $settingsFields;
    }

    public function storeDefaultSettingsToDatabase()
    {
        foreach ($this->getSettingFields(true) as $field) {
            if ($field instanceof Field && $this->hasFieldDefaultValue($field) && $this->hasModel()) {

                $blockSettings = $this->model->settings ?? [];
                $this->model->update([
                    'settings' => array_merge($blockSettings, $this->setSettingValue($blockSettings, $field->getName(), $field->getDefaultState())),
                ]);
            }

            if ($field instanceof Component && $field->hasChildComponentContainer(true)) {
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

        if ($this->checkSettingsEnabled('padding')) {
            $data[] = [
                'name' => 'padding',
                'label' => 'Padding',
            ];
        }

        if ($this->checkSettingsEnabled('text')) {
            $data[] = [
                'name' => 'text',
                'label' => 'Text',
            ];
        }

        if ($this->checkSettingsEnabled('margin')) {
            $data[] = [
                'name' => 'margin',
                'label' => 'Margin',
            ];
        }

        if ($this->checkSettingsEnabled('background')) {
            $data[] = [
                'name' => 'background',
                'label' => 'Background',
            ];
        }

        if ($this->checkSettingsEnabled('height')) {
            $data[] = [
                'name' => 'height',
                'label' => 'Height',
            ];
        }

        if ($this->checkSettingsEnabled('width')) {
            $data[] = [
                'name' => 'width',
                'label' => 'Width',
            ];
        }

        if ($this->checkSettingsEnabled('border')) {
            $data[] = [
                'name' => 'border',
                'label' => 'Border',
            ];
        }

        if($this->checkSettingsEnabled('customAttribute')) {
            $data[] = [
                'name' => 'customattribute',
                'label' => 'Custom Attribute',
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