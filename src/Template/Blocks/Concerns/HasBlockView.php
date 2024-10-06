<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Concerns;

trait HasBlockView
{
    protected $view = '';
    protected $viewPath = [];
    protected $viewPaths = [];

    public function getView()
    {
        if ($this->getType() == 'component') {
            $view = $this->getActiveDesignVariantView() ?? $this->view;
        } else {
            $view = $this->view;
        }
        return $view;
    }

    public function setView($view)
    {
        $this->view = $view;
        return $this;
    }

    public function view($view)
    {
        $this->view = $view;
        return $this;
    }

    public function getViewPath()
    {
        if ($this->getType() == 'component') {
            $viewPath = $this->getActiveDesignVariantViewPath() ?? $this->viewPath;
        } else {
            $viewPath = $this->viewPath;
        }
        return $viewPath;
    }

    public function setViewPath($viewPath)
    {
        $this->viewPath = $viewPath;
        return $this;
    }

    public function getViewPaths()
    {
        return $this->viewPaths;
    }

    public function setViewPaths($viewPaths)
    {
        $this->viewPaths = $viewPaths;
        return $this;
    }

    public function getAllViewPaths()
    {
        return array_merge($this->getViewPaths(), [$this->getViewPath()]);
    }
}