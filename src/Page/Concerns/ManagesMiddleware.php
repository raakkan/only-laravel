<?php

namespace Raakkan\OnlyLaravel\Page\Concerns;

use Illuminate\Support\Arr;

trait ManagesMiddleware
{
    protected $middleware = [];

    protected $middlewareGroups = [];

    protected $middlewareAliases = [];

    public function middleware($middleware)
    {
        if (is_array($middleware)) {
            $this->middleware = array_merge($this->middleware, $middleware);
        } else {
            $this->middleware[] = $middleware;
        }

        return $this;
    }

    public function middlewareGroup($name, array $middleware)
    {
        $this->middlewareGroups[$name] = $middleware;

        return $this;
    }

    public function middlewareAlias($alias, $middleware)
    {
        $this->middlewareAliases[$alias] = $middleware;

        return $this;
    }

    public function getMiddleware()
    {
        return $this->middleware;
    }

    public function getMiddlewareGroups()
    {
        return $this->middlewareGroups;
    }

    public function getMiddlewareAliases()
    {
        return $this->middlewareAliases;
    }

    public function resolveMiddleware($middleware)
    {
        $middleware = Arr::wrap($middleware);

        $resolved = [];

        foreach ($middleware as $name) {
            if (isset($this->middlewareGroups[$name])) {
                $resolved = array_merge($resolved, $this->resolveMiddleware($this->middlewareGroups[$name]));
            } elseif (isset($this->middlewareAliases[$name])) {
                $resolved[] = $this->middlewareAliases[$name];
            } else {
                $resolved[] = $name;
            }
        }

        return $resolved;
    }

    public function getAllMiddleware()
    {
        return $this->resolveMiddleware($this->middleware);
    }

    public function middlewares($middlewares)
    {
        foreach ($middlewares as $middleware) {
            $this->middleware($middleware);
        }

        return $this;
    }

    public function hasMiddleware($middleware = null)
    {
        $resolvedMiddleware = $this->getAllMiddleware();

        if ($middleware === null) {
            return ! empty($resolvedMiddleware);
        }

        $requestedMiddleware = Arr::wrap($middleware);

        foreach ($requestedMiddleware as $m) {
            if (! in_array($m, $resolvedMiddleware)) {
                return false;
            }
        }

        return true;
    }
}
