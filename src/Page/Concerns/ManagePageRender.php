<?php

namespace Raakkan\OnlyLaravel\Page\Concerns;

use Raakkan\OnlyLaravel\Facades\Theme;
use Raakkan\OnlyLaravel\Page\DynamicPage;
use Livewire\Features\SupportPageComponents\PageComponentConfig;
use Livewire\Features\SupportPageComponents\SupportPageComponents;

trait ManagePageRender
{
    protected $view;

    public function render($slug = '')
    {
        if ($slug == '/') {
            $model = $this->getHomeModel();
        } else {
            if ($this instanceof DynamicPage) {
                
                if ($this->hasModels()) {
                    foreach ($this->getModels() as $model) {
                        $model = $model::findBySlug(substr($slug, strrpos($slug, '/') + 1));
                        if ($model) {
                            break;
                        }
                    }
                } else {
                    return abort(404);
                }
            } else {
                try {
                    $model = $this->modelClass::findBySlug($slug);
                } catch (\Exception $e) {
                    $model = '';
                }
            }
        }
        
        // dd($model);

        if (! $model) {
            return abort(404);
        }

        if (Theme::hasView('layouts.app')) {
            return view(Theme::getThemeView('layouts.app'), ['page' => $model]);
        }

        if ($this->view) {
            return view($this->view, [
                'page' => $model,
            ]);
        }

        $view = app('page-manager')->getDefaultPageView();

        if (! view()->exists($view)) {
            return abort(404);
        }

        return view($view, [
            'page' => $model,
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

    public function getHomeModel()
    {
        return $this->modelClass::where('name', 'home-page')
            ->with(['template.blocks' => function ($query) {
                $query->orderBy('order', 'asc');
            }, 'template.parentTemplate.blocks' => function ($query) {
                $query->orderBy('order', 'asc');
            }])
            ->first();
    }

    public function renderLivewire($component, $componentData = [])
    {
        // if (is_subclass_of($this->view, \Livewire\Component::class)) {
        //     return $this->renderLivewire($this->view, ['page' => $page]);
        // }
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
