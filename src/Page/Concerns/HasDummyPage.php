<?php

namespace Raakkan\OnlyLaravel\Page\Concerns;

trait HasDummyPage
{
    protected $dummyPage = false;

    public function setDummyPage($dummyPage = true)
    {
        $this->dummyPage = $dummyPage;

        return $this;
    }

    public function isDummyPage()
    {
        return $this->dummyPage;
    }

    public function dummyPage()
    {
        $this->dummyPage = true;

        return $this;
    }
}
