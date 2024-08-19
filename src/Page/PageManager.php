<?php

namespace Raakkan\OnlyLaravel\Page;

use App\Livewire\Pages\HomePage;
use Raakkan\OnlyLaravel\Models\PageModel;
use Raakkan\OnlyLaravel\Page\Concerns\ManagePages;
use Raakkan\OnlyLaravel\Page\Concerns\ManagePageRender;

class PageManager
{
    use ManagePageRender;
    use ManagePages;

    public function render($slug = null, $pageType = 'pages')
    {
        if ($slug) {
            $slug = trim($slug, '/');
        
            $model = PageModel::where('slug', $slug)->first();
        } else {
            $model = PageModel::where('name', 'home-page')->first();
        }

        if (! $model) {
            return abort(404);
        }

        $page = $this->getPageByName($model->name);
        
        if ($page) {
            $page->setModel($model);
        }else{
            $page = new Page($model->name);
            $page->setModel($model);
        }
        
        return $page->render();
    }

    public function pageIsDeletable(string $name): bool
    {
        $page = $this->getPageByName($name);
        if ($page && $page->isDeletable()) {
            return false;
        }
        return true;
    }
}
