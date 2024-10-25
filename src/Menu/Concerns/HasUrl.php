<?php

namespace Raakkan\OnlyLaravel\Menu\Concerns;

trait HasUrl
{
    protected $url;

    protected $target;

    public function target($target)
    {
        $this->target = $target;

        return $this;
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    public function hasTarget()
    {
        return ! empty($this->target) && ! is_null($this->target);
    }

    public function url($url)
    {
        $this->url = $url;

        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function hasUrl()
    {
        return ! empty($this->url) && ! is_null($this->url);
    }

    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }
}
