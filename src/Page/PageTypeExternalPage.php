<?php

namespace Raakkan\OnlyLaravel\Page;

use Illuminate\Support\Facades\View;

class PageTypeExternalPage
{
    protected $parentPageType;
    protected $slug;
    protected $pageType;

    public static function make($parentPageType, $slug, $pageType)
    {
        return new static($parentPageType, $slug, $pageType);
    }

    public function __construct($parentPageType, $slug, $pageType)
    {
        $this->parentPageType = $parentPageType;
        $this->slug = $slug;
        $this->pageType = $pageType;
    }

    public function getPageType()  
    {
        return app('page-manager')->findPageTypeByType($this->pageType);
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getParentPageType()
    {
        return $this->parentPageType;
    }
}
