<?php

namespace Raakkan\OnlyLaravel\Page;

use Raakkan\OnlyLaravel\Page\Concerns\ManagePages;
use Raakkan\OnlyLaravel\Page\Concerns\ManagePageTypes;

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

        foreach ($pageTypes as $pageType) {
            if ($slug) {
                $slug = trim($slug, '/');
                
                if ($pageType->isExternalModelPage($slug)) {
                    $externalModelPage = $pageType->getExternalModelPage($slug);

                    if($externalModelPage->isRedirectable()){
                        return $externalModelPage->redirect();
                    }

                    $externalPageType = $pageType->getExternalPageType($slug);
                    
                    if($externalPageType){
                        $pageType = $externalPageType;
                        $model = $pageType->getModel($slug);
                    }else{
                        return abort(404);
                    }
                }else{
                    $model = $pageType->getModel($slug);
                }
            } else {
                $model = $pageType->getHomeModel();
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
