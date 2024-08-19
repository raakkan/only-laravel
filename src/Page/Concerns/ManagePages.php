<?php

namespace Raakkan\OnlyLaravel\Page\Concerns;

use Raakkan\OnlyLaravel\Page\Page;
use Raakkan\OnlyLaravel\Models\PageModel;

trait ManagePages
{
    protected $pages = [];

    public function getPageByName($name)
    {
        return collect($this->getPages())->first(function ($page) use ($name) {
            return $page->getName() == $name;
        });
    }

    public function getPages()
    {
        return $this->pages;
    }

    public function registerPages($pages)
    {
        foreach ($pages as $page) {
            $this->registerPage($page);
        }

        return $this;
    }

    public function registerPage($page)
    {
        $this->pages[] = $page;

        return $this;
    }

    public function findPageBySlug($slug)
    {
        $slug = trim($slug, '/');

        return collect($this->getPages())->first(function ($page) use ($slug) {
            return trim($page->getSlug(), '/') == $slug;
        });
    }

    public function createPages()
    {
        foreach ($this->getPages() as $page) {
            $page->create();
        }
        return $this;
    }
    
}
