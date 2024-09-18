<?php

namespace Raakkan\OnlyLaravel\Support\Views;

use Raakkan\OnlyLaravel\Support\Views\ViewModel as View;

trait Viewable
{
    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }

    public function addView()
    {
        $this->views()->create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public function viewCount()
    {
        return $this->views()->count();
    }

    public function uniqueViewCount()
    {
        return $this->views()->distinct('ip_address')->count('ip_address');
    }
}