<?php

namespace Raakkan\OnlyLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
    protected $fillable = ['name', 'location', 'disabled', 'settings'];

    protected $casts = [
        'disabled' => 'boolean',
        'settings' => 'array',
    ];

    public function items()
    {
        return $this->hasMany(MenuItemModel::class, 'menu_id')->orderBy('order', 'asc');
    }

    public function getTable(): string
    {
        return 'menus';
    }
}
