<?php

namespace Raakkan\OnlyLaravel\Page\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Raakkan\OnlyLaravel\Page\DynamicPage;
use Raakkan\OnlyLaravel\Translation\Models\Language;

trait ManagePageRoute
{
    protected $routeName;

    public function getRouteName()
    {
        return $this->routeName ?? $this->getName();
    }

    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;

        return $this;
    }

    public function hasRouteName()
    {
        return isset($this->routeName);
    }

    public function routeName($routeName)
    {
        $this->setRouteName($routeName);

        return $this;
    }

    public function registerRoute($pageManager)
    {
        if ($this->isRoot()) {
            return;
        }

        $page = $this;
        if ($page instanceof DynamicPage) {
            $page->setModels($pageManager->getDynamicModel($this->getName()));
        }

        Route::localized(function () use ($pageManager, $page) {
            $route = Route::get($this->getSlug(), function (Request $request) use ($page) {
                return $page->render($request->path());
            });

            $route->middleware(array_merge($pageManager->getGlobalMiddleware(), $this->getAllMiddleware()));

            $route->name($this->getRouteName());
        }, [
            'supported_locales' => Language::getActiveLocales(),
            'omitted_locale' => Language::getDefaultLocale(),
        ]);
    }
}
