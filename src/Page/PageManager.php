<?php

namespace Raakkan\OnlyLaravel\Page;

use Raakkan\OnlyLaravel\Page\Concerns\ManageDynamicPages;
use Raakkan\OnlyLaravel\Page\Concerns\ManagePages;

class PageManager
{
    use ManageDynamicPages;
    use ManagePages;

    private $app;

    protected $globalMiddleware = ['web'];

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function registerPageRoutes()
    {
        $pages = $this->getPages();

        foreach ($pages as $page) {
            $page->registerRoute($this);
        }
    }

    public function pageIsDeletable(string $name): bool
    {
        $page = $this->getPageByName($name);

        if (! $page) {
            return true;
        }

        return $page->isDeletable();
    }

    public function pageIsDisableable(string $name): bool
    {
        $page = $this->getPageByName($name);

        if (! $page) {
            return true;
        }

        return $page->isDisableable();
    }

    public function getPageNameIsEditable(string $name): bool
    {
        $page = $this->getPageByName($name);

        if (! $page) {
            return true;
        }

        return $page->isNameEditable();
    }

    public function getPageSlugIsEditable(string $name): bool
    {
        $page = $this->getPageByName($name);

        if (! $page) {
            return true;
        }

        return $page->isSlugEditable();
    }

    public function addGlobalMiddleware(string $middleware): void
    {
        if (! in_array($middleware, $this->globalMiddleware)) {
            $this->globalMiddleware[] = $middleware;
        }
    }

    public function removeGlobalMiddleware(string $middleware): void
    {
        if ($middleware !== 'web') {
            $this->globalMiddleware = array_filter($this->globalMiddleware, function ($item) use ($middleware) {
                return $item !== $middleware;
            });
        }
    }

    public function setGlobalMiddleware(array $middleware): void
    {
        $this->globalMiddleware = array_unique(array_merge(['web'], $middleware));
    }

    public function getGlobalMiddleware(): array
    {
        return $this->globalMiddleware;
    }
}
