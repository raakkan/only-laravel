<?php

namespace Raakkan\OnlyLaravel\Page;

class PageTypeExternalPage
{
    protected $parentPageType;

    protected $slug;

    protected $pageType;

    protected $redirectToUrl;

    public static function make($parentPageType, $slug, $pageType = null)
    {
        return new static($parentPageType, $slug, $pageType);
    }

    public function __construct($parentPageType, $slug, $pageType = null)
    {
        $this->parentPageType = $parentPageType;
        $this->slug = $slug;
        $this->pageType = $pageType;
    }

    public function getPageType()
    {
        return $this->pageType;
    }

    public function setPageType($pageType)
    {
        $this->pageType = $pageType;

        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getParentPageType()
    {
        return $this->parentPageType;
    }

    public function redirectTo($url)
    {
        $this->redirectToUrl = $url;

        return $this;
    }

    public function isRedirectable()
    {
        return $this->redirectToUrl ? true : false;
    }

    public function redirect()
    {
        return redirect($this->redirectToUrl);
    }
}
