<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Concerns;

trait HasBlockView
{
    protected $view = '';

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
}