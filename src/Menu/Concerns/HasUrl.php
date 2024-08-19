<?php

namespace Raakkan\OnlyLaravel\Menu\Concerns;

trait HasUrl
{
    protected $url;

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
        return !empty($this->url) && !is_null($this->url);
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }
}