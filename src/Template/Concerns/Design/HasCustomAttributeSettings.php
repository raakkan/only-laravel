<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Components\Textarea;
use Illuminate\Support\Arr;

trait HasCustomAttributeSettings
{
    protected $customAttributeSettings = true;

    public function getCustomAttributes()
    {
        return Arr::get($this->settings, 'onlylaravel.custom_attributes');
    }

    public function getCustomAttributeSettingFields()
    {
        $fields = [];

        if ($this->customAttributeSettings) {
            $fields[] = Textarea::make('onlylaravel.custom_attributes')
                ->label('Custom Attributes')
                ->rows(4)
                ->default($this->getCustomAttributes());
        }

        return $fields;
    }

    public function hasCustomAttributeSettingsEnabled()
    {
        return $this->customAttributeSettings;
    }

    public function customAttributes($attributes = [])
    {
        $this->customAttributeSettings = true;
        Arr::set($this->settings, 'onlylaravel.custom_attributes', $attributes);

        return $this;
    }
}
