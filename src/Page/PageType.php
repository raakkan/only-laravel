<?php

namespace Raakkan\OnlyLaravel\Page;
use Raakkan\OnlyLaravel\Support\Concerns\HasGroup;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;

class PageType
{
    use Makable;
    use HasName;
    use HasGroup;

    public $type;
    public $defaultView;
    public $model;

    public function __construct($type, $name, $group, $defaultView, $model)
    {
        $this->type = $type;
        $this->name = $name;
        $this->defaultView = $defaultView;
        $this->model = $model;
        $this->group = $group;
    }

    public function allRequiredFieldsFilled()
    {
        return isset($this->name) && isset($this->type) && isset($this->defaultView) && isset($this->model) && isset($this->group);
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
