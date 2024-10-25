<?php

namespace Raakkan\OnlyLaravel\Page\Concerns;

trait HasPageType
{
    protected $pageType = 'page';

    public function setPageType($pageType)
    {
        $this->pageType = $pageType;

        return $this;
    }

    public function pageType($pageType)
    {
        $this->pageType = $pageType;

        return $this;
    }

    public function getPageType()
    {
        return $this->pageType;
    }

    public function hasPageType()
    {
        return isset($this->pageType);
    }
}
