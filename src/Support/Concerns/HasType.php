<?php

namespace Raakkan\OnlyLaravel\Support\Concerns;

trait HasType
{
    protected $type;

    public function type($type)
    {
        return $this->setType($type);
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function isType($type)
    {
        return $this->getType() === $type;
    }

    public function hasType()
    {
        return ! is_null($this->type);
    }
}
