<?php

namespace Raakkan\OnlyLaravel\Plugin\Concerns;

trait PluginActivation
{
    protected $activated = false;

    public function activate()
    {
        $this->activated = true;
    }

    public function deactivate()
    {
        $this->activated = false;
    }

    public function isActivated()
    {
        return $this->activated;
    }

    public function setActivated(bool $activated)
    {
        $this->activated = $activated;

        return $this;
    }
}
