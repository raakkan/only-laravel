<?php

namespace Raakkan\OnlyLaravel\Support\Validation\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Raakkan\OnlyLaravel\Facades\PageManager;

class UniqueSlug implements Rule
{
    protected $tables;

    public function __construct()
    {
        $this->tables = PageManager::getPageTables();
    }

    public function passes($attribute, $value)
    {
        foreach ($this->tables as $table) {
            if (DB::table($table)->where('slug', $value)->exists()) {
                return false;
            }
        }

        return true;
    }

    public function message()
    {
        return 'The :attribute has already been taken.';
    }
}
