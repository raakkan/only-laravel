<?php

namespace Raakkan\OnlyLaravel\Page;

class Page extends BasePage
{
    public function __construct($name)
    {
        $this->name = $name;
    }
}