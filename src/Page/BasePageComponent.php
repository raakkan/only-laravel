<?php

namespace Raakkan\OnlyLaravel\Page;

use Livewire\Component;
use Raakkan\OnlyLaravel\Models\PageModel;

class BasePageComponent extends Component
{
    public PageModel $page;
    public $view;
    public $layout;

    protected function getViewData()
    {
        return [];
    }

    protected function getLayoutData()
    {
        return [];
    }

    protected function getView()
    {
        return $this->view;
    }

    protected function getLayout()
    {
        return $this->layout;
    }

    public function render()
    {
        return view($this->getView())->extends($this->getLayout(), array_merge($this->getLayoutData(), ['template' => $this->page->template]))
            ->with($this->getViewData());
    }
}
