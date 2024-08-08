<?php

namespace Raakkan\OnlyLaravel\Theme\Template\Blocks;

use Raakkan\OnlyLaravel\Theme\Enums\BackgroundType;

class HeaderBlock extends Block
{
    protected string $name = 'header';
    protected $group = 'core';
    protected $source = 'raakkan/only-laravel';
    protected $deletable = false;
    protected $sortable = false;
    protected $backgroundSettings = true;
    protected $backgroundType = BackgroundType::BOTH;
    protected $background = [
        'color' => '#00e693',
        'image' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=870&q=80'
    ];

    public function __construct()
    {
    }
}