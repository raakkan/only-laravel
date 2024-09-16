<?php

namespace Raakkan\OnlyLaravel\Page\Concerns;
use Raakkan\OnlyLaravel\Page\PageType;
use Raakkan\OnlyLaravel\Models\PageModel;
use Raakkan\OnlyLaravel\Page\PageTypeExternalPage;

trait ManagePageTypes
{
    protected $pageTypes = [];
    protected $defaultPageTypeView = 'only-laravel::pages.default-page';
    protected $defaultPageTypeModel = PageModel::class;

    protected $otherModels = [];

    public function getPageTypes()
    {
        $this->pageTypes = array_merge($this->pageTypes, [$this->getDefaultPageType()]);
        return $this->pageTypes;
    }

    public function getPageTypeModels()
    {
        return collect($this->getPageTypes())
            ->map(function ($pageType) {
                return $pageType->getModelClass();
            })
            ->unique()
            ->values()
            ->toArray();
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
        return PageType::make('pages', 'root', null, $this->defaultPageTypeView, $this->defaultPageTypeModel)->registerJsonSchema(function ($schema) {
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
        })->group('Pages');
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

    public function getPageTypesByType($type)
    {
        return collect($this->getPageTypes())->filter(function ($pageType) use ($type) {
            return $pageType->getType() == $type;
        })->toArray();
    }

    public function getDefaultPageTypeView()
    {
        return $this->defaultPageTypeView;
    }

    public function getDefaultPageTypeModel()
    {
        return $this->defaultPageTypeModel;
    }

    public function registerExternalModelPages(array $externalModelPages = [])
    {
        foreach ($externalModelPages as $externalModelPage) {
            $parentPageType = $externalModelPage->getParentPageType();
            if ($parentPageType) {
                $pageType = $this->findPageTypeByType($parentPageType);
                if ($pageType && $externalModelPage instanceof PageTypeExternalPage) {
                    if($externalModelPage->getPageType()){
                        $externalModelPage = $externalModelPage->setPageType($this->findPageTypeByType($externalModelPage->getPageType()));
                    }
                    $pageType->registerExternalModelPage($externalModelPage);
                    $this->updatePageType($pageType);
                }
            }
        }
        return $this;
    }

    public function updatePageType(PageType $pageType)
    {
        $this->pageTypes = collect($this->pageTypes)->map(function ($item) use ($pageType) {
            if ($item->getType() == $pageType->getType()) {
                return $pageType;
            }
            return $item;
        })->toArray();
        return $this;
    }

    public function registerOtherModels($models)
    {
        foreach ($models as $model) {
            $this->registerOtherModel($model);
        }
        return $this;
    }

    public function registerOtherModel($model)
    {
        if (is_subclass_of($model, \Illuminate\Database\Eloquent\Model::class) && $this->isModelHasSlug($model)) {
            $this->otherModels[] = $model;
        } else {
            throw new \InvalidArgumentException('The provided model must be a child of Eloquent Model and have a slug property.');
        }
        return $this;
    }

    public function isModelHasSlug($model)
    {
        $model = new $model();
        return $model->isFillable('slug');
    }

    public function getAllModels()
    {
        return array_merge($this->getPageTypeModels(), $this->otherModels);
    }
}