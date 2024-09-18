<?php

namespace Raakkan\OnlyLaravel\Support\Views;

use Illuminate\Database\Eloquent\Model;

class ViewModel extends Model
{
    protected $table = 'views';
    protected $fillable = ['ip_address', 'user_agent'];

    public function viewable()
    {
        return $this->morphTo();
    }
}