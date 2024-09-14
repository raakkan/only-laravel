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
                    $externalPageType = $pageType->getExternalPageType($slug);
                    
                    if($externalPageType){
                        $pageType = $externalPageType;
                        match($driver){
                            'mysql' => $model = $externalPageType->getModel()::where(function($query) use ($slug) {
                                $query->where('slug->'. app()->getLocale(), $slug)
                                      ->orWhere('slug->en', $slug);
                            })->with('template.blocks')->first(),
                            'mariadb' => $model = $externalPageType->getModel()::where(function($query) use ($slug) {
                                $query->whereRaw("JSON_EXTRACT(slug, '$." . app()->getLocale() . "') = ?", [$slug])
                                      ->orWhereRaw("JSON_EXTRACT(slug, '$.en') = ?", [$slug]);
                            })->with('template.blocks')->first(),
                            'pgsql' => $model = $externalPageType->getModel()::where(function($query) use ($slug) {
                                $query->where("slug->>'" . app()->getLocale() . "'", $slug)
                                      ->orWhere("slug->>'en'", $slug);
                            })->with('template.blocks')->first(),
                            'sqlsrv' => $model = $externalPageType->getModel()::where(function($query) use ($slug) {
                                $query->where("JSON_VALUE(slug, '$." . app()->getLocale() . "')", $slug)
                                      ->orWhere("JSON_VALUE(slug, '$.en')", $slug);
                            })->with('template.blocks')->first(),
                        };
                    }else{
                        return abort(404);
                    }
                    
                }else{
                    match($driver){
                        'mysql' => $model = $pageType->getModel()::where(function($query) use ($slug) {
                            $query->where('slug->'. app()->getLocale(), $slug)
                                  ->orWhere('slug->en', $slug);
                        })->with('template.blocks')->first(),
                        'mariadb' => $model = $pageType->getModel()::where(function($query) use ($slug) {
                            $query->whereRaw("JSON_EXTRACT(slug, '$." . app()->getLocale() . "') = ?", [$slug])
                                  ->orWhereRaw("JSON_EXTRACT(slug, '$.en') = ?", [$slug]);
                        })->with('template.blocks')->first(),
                        'pgsql' => $model = $pageType->getModel()::where(function($query) use ($slug) {
                            $query->where("slug->>'" . app()->getLocale() . "'", $slug)
                                  ->orWhere("slug->>'en'", $slug);
                        })->with('template.blocks')->first(),
                        'sqlsrv' => $model = $pageType->getModel()::where(function($query) use ($slug) {
                            $query->where("JSON_VALUE(slug, '$." . app()->getLocale() . "')", $slug)
                                  ->orWhere("JSON_VALUE(slug, '$.en')", $slug);
                        })->with('template.blocks')->first(),
                    };
                }
            } else {
                $model = $pageType->getModel()::where('name', 'home-page')->with('template.blocks')->first();
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

        $page = $this->getPageByName($model->getName());
        
        if ($page) {
            $page->setModel($model);
            
            if (!$page->hasView()) {
                $page->setView($pageType->getDefaultView() ?? $this->getDefaultPageTypeView());
            }
        }else{
            $page = new Page($model->getName());
            $page->setView($pageType->getDefaultView() ?? $this->getDefaultPageTypeView());
            $page->setModel($model);
        }
        
        return $page->render();
    }

    public function pageIsDeletable(string $name): bool
    {
        $page = $this->getPageByName($name);
        
        if(! $page) {
            return true;
        }

        if ($page && $page->isDeletable()) {
            return true;
        }
        return false;
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
