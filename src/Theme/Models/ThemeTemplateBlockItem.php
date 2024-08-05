<?php

namespace Raakkan\OnlyLaravel\Theme\Models;

use Illuminate\Database\Eloquent\Model;

class ThemeTemplateBlockItem extends Model
{
    protected $fillable = ['name', 'source', 'order', 'type', 'settings', 'block_id'];

    protected $casts = [
        'settings' => 'array',
    ];

    public function block()
    {
        return $this->belongsTo(ThemeTemplateBlock::class, 'block_id');
    }
}
