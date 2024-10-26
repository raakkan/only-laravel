<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Concerns;

trait HasBlockView
{
    protected $view = '';

    protected $viewPath = [];

    protected $viewPaths = [];

    public function getView()
    {
        return $this->view;
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
        return $this->viewPath;
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
