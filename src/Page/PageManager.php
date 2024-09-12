<?php

namespace Raakkan\OnlyLaravel\Page;

use App\Livewire\Pages\HomePage;
use Raakkan\Blog\Models\Post;
use Raakkan\OnlyLaravel\Models\PageModel;
use Raakkan\OnlyLaravel\Page\Concerns\ManagePages;
use Raakkan\OnlyLaravel\Page\Concerns\ManagePageTypes;
use Raakkan\OnlyLaravel\Page\Concerns\ManagePageRender;

class PageManager
{
    use ManagePages;
    use ManagePageTypes;

    public function render($slug = null, $level = 'root')
    {
        $model = null;
        $pageTypes = $this->getPageTypesByLevel($level);
        
        if (count($pageTypes) == 0) {
            return abort(404);
        }

        $driver = \DB::getDriverName();

        foreach ($pageTypes as $pageType) {
            if ($slug) {
                $slug = trim($slug, '/');

                if ($pageType->isExternalModelPage($slug)) {
                    return $pageType->getExternalModelPage($slug);
                }else{
                    match($driver){
                        'mysql' => $model = $pageType->getModel()::where('slug->'. app()->getLocale(), $slug)->with('template.blocks')->first(),
                        'mariadb' => $model = $pageType->getModel()::whereRaw("JSON_EXTRACT(slug, '$.'". app()->getLocale() .") = '".$slug."'")->with('template.blocks')->first(),
                    };
                }
            } else {
                match($driver){
                    'mysql' => $model = $pageType->getModel()::where('name', 'home-page')->with('template.blocks')->first(),
                    'mariadb' => $model = $pageType->getModel()::whereRaw("JSON_EXTRACT(name, '$.'". app()->getLocale() .") = '".$slug."'")->with('template.blocks')->first(),
                };
            }

            if ($model) {
                break;
            }
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
            $page->setView($pageType->getDefaultView() ?? $this->getDefaultPageTypeView());
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
