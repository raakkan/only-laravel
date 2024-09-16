<?php

namespace Raakkan\OnlyLaravel\Menu;
use Raakkan\OnlyLaravel\Facades\PageManager;
use Raakkan\OnlyLaravel\Menu\Concerns\HandleMenus;
use Raakkan\OnlyLaravel\Plugin\Facades\PluginManager;
use Raakkan\OnlyLaravel\Menu\Concerns\HandleMenuLocations;

class MenuManager
{
    use HandleMenus;
    use HandleMenuLocations;
    protected $items = [];

    public function getItems()
    {
        return array_merge($this->getPageMenuItems(), $this->items);
    }

    public function getPageMenuItems()
    {
        $models = array_filter(PageManager::getAllModels(), 'is_string');
        
        $items = [];
        foreach ($models as $model) {
            $data = $model::get();
            foreach ($data as $item) {
                $pageType = PageManager::findPageTypeByType($item->getPageType());
                if ($pageType->isExternalModelPage($item->slug)) {
                    continue;
                }
                $items[] = MenuItem::make($item->getName())->url($pageType->generateUrl($item->slug))->label($item->title ?? $item->getName())->group($pageType->getGroup());
            }
        }
        
        return $items;
    }
}
