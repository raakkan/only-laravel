<?php

namespace Raakkan\OnlyLaravel\Page;
use Raakkan\OnlyLaravel\Support\Concerns\HasGroup;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;

class PageType
{
    use Makable;
    use HasName;

    public $type;
    public $defaultView;
    public $model;
    public $level;
    public $jsonSchema;
    public $parentSlug;

    public function __construct($type, $name, $level, $parentSlug, $defaultView, $model)
    {
        $this->type = $type;
        $this->name = $name;
        $this->defaultView = $defaultView;
        $this->model = $model;
        $this->level = $level;
        $this->parentSlug = $parentSlug;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getDefaultView()
    {
        return $this->defaultView;
    }

    public function getModel()
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
        return $this->parentSlug ? url($this->parentSlug . '/' . $slug) : url($slug);
    }

    public function generateJsonLd($page)
    {
        return $this->jsonSchema->generateJsonLd($page, $this);
    }
}
