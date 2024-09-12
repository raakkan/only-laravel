<?php

namespace Raakkan\OnlyLaravel\Page\Concerns;

use Illuminate\Support\Facades\Blade;
use Livewire\Features\SupportPageComponents\PageComponentConfig;
use Livewire\Features\SupportPageComponents\SupportPageComponents;

trait ManagePageRender
{
    protected $view;

    public function render()
    {
        $page = $this->getModel();

        if (!$this->view) {
            return abort(404);
        }

        if (is_subclass_of($this->view, \Livewire\Component::class)) {
            return $this->renderLivewire($this->view, ['page' => $page]);
        }

        if (! view()->exists($this->view)) {
            return abort(404);
        }
        
        return view($this->view, [
            'page' => $page,
        ]);
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

    public function hasView()
    {
        return isset($this->view);
    }

    public function renderLivewire($component, $componentData = [])
    {
        $html = null;

        $layoutConfig = SupportPageComponents::interceptTheRenderOfTheComponentAndRetreiveTheLayoutConfiguration(function () use (&$html, $component, $componentData) {
            $params = SupportPageComponents::gatherMountMethodParamsFromRouteParameters($component);

            $html = app('livewire')->mount($component, array_merge($params, $componentData));
        });

        $layoutConfig = $layoutConfig ?: new PageComponentConfig;

        $layoutConfig->normalizeViewNameAndParamsForBladeComponents();

        $response = response(SupportPageComponents::renderContentsIntoLayout($html, $layoutConfig));

        if (is_callable($layoutConfig->response)) {
            call_user_func($layoutConfig->response, $response);
        }

        return $response;
    }
}
