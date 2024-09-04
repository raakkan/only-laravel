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
        return PageType::make('pages', 'Pages', 'root', $this->defaultPageTypeView, $this->defaultPageTypeModel);
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

}