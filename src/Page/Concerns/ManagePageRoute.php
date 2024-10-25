<?php

namespace Raakkan\OnlyLaravel\Page\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

trait ManagePageRoute
{
    protected $routeName;

    public function getRouteName()
    {
        return $this->routeName;
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
        $route = Route::get($this->getSlug(), function (Request $request) {
            return $this->render($request->path());
        });

        $route->middleware(array_merge($pageManager->getGlobalMiddleware(), $this->getAllMiddleware()));

        $route->name($this->getRouteName());
    }
}
