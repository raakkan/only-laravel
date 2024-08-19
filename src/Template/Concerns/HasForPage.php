<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

trait HasForPage
{
    protected $forPage = 'all';
    protected $forPageType = 'pages';

    public function forPageType($forPageType)
    {
        $this->forPageType = $forPageType;
        return $this;
    }

    public function getForPageType()
    {
        return $this->forPageType;
    }

    public function setForPageType($forPageType)
    {
        $this->forPageType = $forPageType;

        return $this;
    }

    public function forPage($forPage)
    {
        $this->forPage = $forPage;
        return $this;
    }

    public function getForPage()
    {
        return $this->forPage;
    }

    public function setForPage($forPage)
    {
        $this->forPage = $forPage;
    }
}