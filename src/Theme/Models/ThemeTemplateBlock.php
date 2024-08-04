<?php

namespace Raakkan\OnlyLaravel\Theme\Models;

use Illuminate\Database\Eloquent\Model;

class ThemeTemplateBlock extends Model
{
    protected $fillable = ['name', 'label', 'source', 'order', 'settings', 'template_id', 'parent_id'];

    protected $casts = [
        'settings' => 'array',
    ];

    public function template()
    {
        return $this->belongsTo(ThemeTemplate::class, 'template_id');
    }

    public function parent()
    {
        return $this->belongsTo(ThemeTemplateBlock::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ThemeTemplateBlock::class, 'parent_id');
    }

    public function items()
    {
        return $this->hasMany(ThemeTemplateBlockItem::class, 'block_id');
    }
}
