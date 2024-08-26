<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

trait HasForPage
{
    protected $forPage = 'all';

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