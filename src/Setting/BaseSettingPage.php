<?php

namespace Raakkan\OnlyLaravel\Setting;

use Livewire\Component;

class BaseSettingPage extends Component
{
    protected static string $routeName = '';

    protected static string $slug = '';

    protected static string $navigationIcon = '';
    
    protected static string $navigationLabel = '';

    public $data = [];

    public function form()
    {
    }

    public function save()
    {
    }
}
