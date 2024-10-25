<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

trait Sortable
{
    protected $sortable = true;

    public function sortable($sortable)
    {
        $this->sortable = $sortable;

        return $this;
    }

    public function setSortable($sortable)
    {
        $this->sortable = $sortable;

        return $this;
    }

    public function isSortable()
    {
        return $this->sortable;
    }
}
