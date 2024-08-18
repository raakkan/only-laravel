<?php

namespace Raakkan\OnlyLaravel\Page\Concerns;

use Livewire\Features\SupportPageComponents\PageComponentConfig;
use Livewire\Features\SupportPageComponents\SupportPageComponents;

trait ManagePageRender
{
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
