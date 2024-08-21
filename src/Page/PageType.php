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

    public function __construct($type, $name, $level, $defaultView, $model)
    {
        $this->type = $type;
        $this->name = $name;
        $this->defaultView = $defaultView;
        $this->model = $model;
        $this->level = $level;
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
}
