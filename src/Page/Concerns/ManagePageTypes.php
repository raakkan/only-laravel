<?php

namespace Raakkan\OnlyLaravel\Page\Concerns;
use Raakkan\OnlyLaravel\Page\PageType;
use Raakkan\OnlyLaravel\Models\PageModel;

trait ManagePageTypes
{
    protected $pageTypes = [];
    protected $defaultPageTypeView = 'only-laravel::pages.default-page';
    protected $defaultPageTypeModel = PageModel::class;

    public function getPageTypes()
    {
        return array_merge($this->pageTypes, [$this->getDefaultPageType()]);
    }

    public function getPageTypeModels()
    {
        return collect($this->getPageTypes())->flatMap(function ($pageType) {
            return [$pageType->getModel() => basename($pageType->getModel())];
        })->toArray();
    }

    public function registerPageTypes($pageTypes)
    {
        foreach ($pageTypes as $pageType) {
            if ($pageType instanceof PageType) {
                $this->registerPageType($pageType);
            }
        }
        return $this;
    }

    public function registerPageType(PageType $pageType)
    {
        if(! $this->isPageTypeExist($pageType->getType())) {
            $this->pageTypes[] = $pageType;
        }
        return $this;
    }

    public function findPageTypeByType($type)
    {
        return collect($this->getPageTypes())->first(function ($pageType) use ($type) {
            return $pageType->getType() == $type;
        });
    }

    public function isPageTypeExist($type)
    {
        return collect($this->getPageTypes())->first(function ($pageType) use ($type) {
            return $pageType->getType() == $type;
        });
    }

    public function getDefaultPageType()
    {
        return PageType::make('pages', 'Pages', 'root', null, $this->defaultPageTypeView, $this->defaultPageTypeModel)->registerJsonSchema(function ($schema) {
            $schema->setType('WebPage');
            $schema->setProperty('@id', 'string', ['instruction' => function ($page, $pageType) {
                return $pageType->generateUrl($page->slug);
            }]);
            $schema->setProperty('url', 'string', ['instruction' => function ($page, $pageType) {
                return $pageType->generateUrl($page->slug);
            }]);
            $schema->setProperty('name', 'string', ['instruction' => function ($page) {
                if (isset($page->seo_title) && $page->seo_title != '') {
                    return $page->seo_title;
                } else {
                    return $page->title;
                }
            }]);
            $schema->setProperty('description', 'string', ['instruction' => function ($page) {
                return $page->seo_description;
            }]);
            $schema->setProperty('image', 'string', ['instruction' => function ($page) {
                return $page->getFeaturedImageUrl();
            }]);
            $schema->setProperty('datePublished', 'string', ['instruction' => function ($page) {
                return $page->created_at->toIso8601String();
            }]);
            $schema->setProperty('dateModified', 'string', ['instruction' => function ($page) {
                return $page->updated_at->toIso8601String();
            }]);
            $schema->setProperty('inLanguage', 'string', ['instruction' => function () {
                return app()->getLocale();
            }]);
        });
    }

    public function useDefaultPageTypeView($view)
    {
        $this->defaultPageTypeView = $view;
        return $this;
    }

    public function useDefaultPageTypeModel($model)
    {
        $this->defaultPageTypeModel = $model;
        return $this;
    }

    public function getPageTypesByLevel($level)
    {
        return collect($this->getPageTypes())->filter(function ($pageType) use ($level) {
            return $pageType->getLevel() == $level;
        })->toArray();
    }
}