<?php

namespace Raakkan\OnlyLaravel\Page;
use Raakkan\OnlyLaravel\Support\Concerns\HasGroup;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;

class PageType
{
    use Makable;
    use HasGroup;

    public $type;
    public $defaultView;
    public $model;
    public $level;
    public $jsonSchema;
    public $parentSlug;
    public $externalModelPages = [];
    public $skipParentSlugForSlugs = [];

    public function __construct($type, $level, $parentSlug, $defaultView, string | callable $model, $group = null)
    {
        $this->type = $type;
        $this->defaultView = $defaultView;
        $this->model = $model;
        $this->level = $level;
        $this->parentSlug = $parentSlug;
        $this->group = $group;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getDefaultView()
    {
        return $this->defaultView;
    }

    public function getHomeModel()
    {
        return $this->model::where('name', 'home-page')->with('template.blocks')->first();
    }

    public function getModel($slug)
    {
        if (is_string($this->model)) {
            if (is_subclass_of($this->model, \Illuminate\Database\Eloquent\Model::class)) {
                return $this->model::findBySlug($slug);
            }
        } elseif (is_callable($this->model)) {
            $model = call_user_func($this->model, $slug, $this);
            if ($model instanceof \Illuminate\Database\Eloquent\Model) {
                return $model;
            }
        }
        return null;
    }

    public function getModelClass()
    {
        return $this->model;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function registerJsonSchema(callable $callback)
    {
        $jsonSchema = new JsonPageSchema();
        $callback($jsonSchema);
        $this->jsonSchema = $jsonSchema;
        return $this;
    }

    public function generateUrl($slug)
    {
        return $this->parentSlug && !$this->shouldSkipParentSlugForSlug($slug) ? url($this->parentSlug . '/' . $slug) : url($slug);
    }

    public function generateJsonLd($page)
    {
        return $this->jsonSchema->generateJsonLd($page, $this);
    }

    public function registerExternalModelPages(array $externalModelPages = [])
    {
        foreach ($externalModelPages as $externalModelPage) {
            $this->registerExternalModelPage($externalModelPage);
        }
        return $this;
    }

    public function registerExternalModelPage(PageTypeExternalPage $externalModelPage)
    {
        $this->externalModelPages[] = $externalModelPage;
        return $this;
    }

    public function isExternalModelPage($slug)
    {
        return collect($this->externalModelPages)->contains(function ($externalModelPage) use ($slug) {
            return $externalModelPage->getSlug() == $slug;
        });
    }

    public function getExternalModelPage($slug)
    {
        return collect($this->externalModelPages)->first(function ($externalModelPage) use ($slug) {
            return $externalModelPage->getSlug() == $slug;
        });
    }

    public function getExternalPageType($slug)
    {
        return collect($this->externalModelPages)->first(function ($externalModelPage) use ($slug) {
            return $externalModelPage->getSlug() == $slug;
        })?->getPageType();
    }

    public function skipParentSlugForSlugs($slugs)
    {
        $this->skipParentSlugForSlugs = array_merge($this->skipParentSlugForSlugs, $slugs);
        return $this;
    }

    public function skipParentSlugForSlug($slug)
    {
        $this->skipParentSlugForSlugs[] = $slug;
        return $this;
    }

    public function shouldSkipParentSlugForSlug($slug)
    {
        return in_array($slug, $this->skipParentSlugForSlugs);
    }
}
