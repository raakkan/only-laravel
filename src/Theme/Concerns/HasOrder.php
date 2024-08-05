<?php

namespace Raakkan\OnlyLaravel\Theme\Concerns;

trait HasOrder
{
    protected $order = 0;

    public function order($order)
    {
        $this->order = $order;
        return $this;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }
}