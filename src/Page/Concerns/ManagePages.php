<?php

namespace Raakkan\OnlyLaravel\Page\Concerns;

trait ManagePages
{
    protected $pages = [];

    protected $defaultPageView = 'only-laravel::pages.default-page';

    public function useDefaultPageView($view)
    {
        $this->defaultPageView = $view;

        return $this;
    }

    public function getDefaultPageView()
    {
        return $this->defaultPageView;
    }

    public function getPageByName($name)
    {
        return collect($this->getPages())->first(function ($page) use ($name) {
            return $page->getName() == $name;
        });
    }

    public function getPages()
    {
        // return array_merge($this->pages, app('plugin-manager')->getPages());
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

    public function getAllModels()
    {
        $models = collect($this->getPages())->map(function ($page) {
            return $page->getModelClass();
        })->filter()->values();

        $dynamicModels = collect($this->getDynamicModels())
            ->flatten()
            ->filter();

        $models = $models->merge($dynamicModels)
            ->unique()
            ->values()
            ->toArray();

        return $models;
    }

    public function isRootPage($slug)
    {
        $page = $this->findPageBySlug($slug);

        if ($page) {
            return $page->isRoot();
        }

        return false;
    }
}
