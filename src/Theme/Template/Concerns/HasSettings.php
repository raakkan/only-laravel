<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Concerns;

trait HasSettings
{
    protected $settings = [];

    public function settings($settings)
    {
        $this->settings = $settings;
        return $this;
    }

    public function addSetting($setting)
    {
        $this->settings[] = $setting;
        return $this;
    }

    public function getSettings()
    {
        if ($this->backgroundSettingsEnabled()) {
            return array_merge($this->getBackgroundSettings(), $this->settings);
        }

        return $this->settings;
    }
}