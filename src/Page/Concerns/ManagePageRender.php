<?php

namespace Raakkan\OnlyLaravel\Page\Concerns;

use Livewire\Features\SupportPageComponents\PageComponentConfig;
use Livewire\Features\SupportPageComponents\SupportPageComponents;
use Raakkan\OnlyLaravel\Facades\Theme;
use Raakkan\OnlyLaravel\Models\Redirect;
use Raakkan\OnlyLaravel\Page\DynamicPage;

trait ManagePageRender
{
    protected $view;

    public function render($slug = '')
    {
        $slug = trim($slug, '/');

        $isRootPage = app('page-manager')->isRootPage($slug);

        if ($isRootPage) {
            // TODO: pending meddleware
            $page = app('page-manager')->findPageBySlug($slug);
            $modelClass = $page->getModelClass();
            $model = $modelClass::findBySlug($slug);
        } else {

            if ($slug == 'admin') {
                return app()->make(\App\Http\Middleware\Admin::class)->handle(request(), function () {
                    return $this->renderLivewire(\App\Livewire\Admin\Dashboard::class, [], 'layouts.admin');
                });
            }

            if ($slug == '') {
                $model = $this->getHomeModel();
            } else {
                if ($this instanceof DynamicPage) {

                    if ($this->hasModels()) {

                        if (str_contains($slug, '/')) {
                            $slug = substr($slug, strrpos($slug, '/') + 1);
                        }

                        foreach ($this->getModels() as $model) {
                            $model = $model::findBySlug($slug);
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

        }

        if (! $model) {
            $redirects = Redirect::getCachedRedirects();
            $redirect = $redirects->where('from_path', $slug)->first();
            if ($redirect) {
                return redirect($redirect->to_path, $redirect->status_code);
            }

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
        $cacheKey = 'page_slug_home';
        if ($cachedPage = cache($cacheKey)) {
            $page = unserialize(serialize($cachedPage));

            return $page;
        }

        $page = $this->modelClass::where('name', 'home-page')
            ->with(['template.blocks' => function ($query) {
                $query->orderBy('order', 'asc');
            }, 'template.parentTemplate.blocks' => function ($query) {
                $query->orderBy('order', 'asc');
            }])
            ->first();

        cache()->forever($cacheKey, $page);

        return $page;
    }

    public function renderLivewire($component, $componentData = [], $layout = null)
    {
        $html = null;

        $layoutConfig = SupportPageComponents::interceptTheRenderOfTheComponentAndRetreiveTheLayoutConfiguration(function () use (&$html, $component, $componentData) {
            $params = SupportPageComponents::gatherMountMethodParamsFromRouteParameters($component);
            $html = app('livewire')->mount($component, array_merge($params, $componentData));
        });

        $layoutConfig = $layoutConfig ?: new PageComponentConfig;

        if ($layout) {
            $layoutConfig->layout = $layout;
        }

        $layoutConfig->normalizeViewNameAndParamsForBladeComponents();

        $response = response(SupportPageComponents::renderContentsIntoLayout($html, $layoutConfig));

        if (is_callable($layoutConfig->response)) {
            call_user_func($layoutConfig->response, $response);
        }

        return $response;
    }
}
