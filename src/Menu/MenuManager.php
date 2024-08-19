<?php

namespace Raakkan\OnlyLaravel\Menu;
use Raakkan\OnlyLaravel\Facades\PageManager;
use Raakkan\OnlyLaravel\Menu\Concerns\HandleMenus;

class MenuManager
{
    use HandleMenus;
    protected $locations = [];
    protected $items = [];

    public function getLocations()
    {
        return array_merge($this->getCoreMenuLocations(), $this->locations);
    }

    public function getItems()
    {
        return array_merge($this->getPageMenuItems(), $this->items);
    }

    public function getCoreMenuLocations()
    {
        return [
            'header',
            'footer',
        ];
    }

    public function getPageMenuItems()
    {
        $pageTypes = PageManager::getPageTypes();
        
        $items = [];
        foreach ($pageTypes as $pageType) {
            $pageModel = $pageType->getModel();

            $pages = $pageModel::where('disabled', 0)->get();
            foreach ($pages as $page) {
                $items[] = MenuItem::make($page->name)->url($page->slug)->label($page->title)->group($pageType->getName());
            }
        }
        return $items;
    }
}
