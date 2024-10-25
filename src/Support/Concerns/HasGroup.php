<?php

namespace Raakkan\OnlyLaravel\Support\Concerns;

trait HasGroup
{
    protected $group;

    public function getGroup()
    {
        return $this->group;
    }

    public function setGroup($group)
    {
        $this->group = $group;

        return $this;
    }

    public function group($group)
    {
        return $this->setGroup($group);
    }

    public function hasGroup()
    {
        return ! is_null($this->group);
    }
}
