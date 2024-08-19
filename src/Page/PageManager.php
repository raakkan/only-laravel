<?php

namespace Raakkan\OnlyLaravel\Page;

use App\Livewire\Pages\HomePage;
use Raakkan\OnlyLaravel\Models\PageModel;
use Raakkan\OnlyLaravel\Page\Concerns\ManagePages;
use Raakkan\OnlyLaravel\Page\Concerns\ManagePageTypes;
use Raakkan\OnlyLaravel\Page\Concerns\ManagePageRender;

class PageManager
{
    use ManagePageRender;
    use ManagePages;
    use ManagePageTypes;

    public function render($slug = null, $pageType = 'pages')
    {
        $pageType = $this->findPageTypeByType($pageType);
        if (! $pageType) {
            return abort(404);
        }
        
        if ($slug) {
            $slug = trim($slug, '/');
        
            $model = $pageType->getModel()::where('slug', $slug)->with('template')->first();
        } else {
            $model = $pageType->getModel()::where('name', 'home-page')->with('template')->first();
        }

        if (! $model) {
            return abort(404);
        }

        if ($model->disabled) {
            return abort(404);
        }

        $page = $this->getPageByName($model->name);
        
        if ($page) {
            $page->setModel($model);
            if (!$page->hasView()) {
                $page->setView($pageType->getDefaultView());
            }
        }else{
            $page = new Page($model->name);
            $page->setView($pageType->getDefaultView());
            $page->setModel($model);
        }
        
        return $page->render();
    }

    public function pageIsDeletable(string $name): bool
    {
        $page = $this->getPageByName($name);

        if(! $page) {
            return false;
        }

        if ($page && $page->isDeletable()) {
            return false;
        }
        return true;
    }

    public function pageIsDisableable(string $name): bool
    {
        $page = $this->getPageByName($name);

        if(! $page) {
            return false;
        }
        if ($page && $page->isDisableable()) {
            return false;
        }
        return true;
    }
}
