<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

trait Disableable
{
    protected $disableable = true;

    protected $disabled = false;

    public function disable()
    {
        $this->disabled = true;

        return $this;
    }

    public function enable()
    {
        $this->disabled = false;

        return $this;
    }

    public function isDisabled()
    {
        return $this->disabled;
    }

    public function isDisableable()
    {
        return $this->disableable;
    }

    public function setDisableable($disableable)
    {
        $this->disableable = $disableable;

        return $this;
    }

    public function disableable()
    {
        return $this->setDisableable(true);
    }
}
