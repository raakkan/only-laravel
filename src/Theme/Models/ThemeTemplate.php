<?php

namespace Raakkan\OnlyLaravel\Theme\Models;

use Illuminate\Database\Eloquent\Model;

class ThemeTemplate extends Model
{
    protected $fillable = ['name', 'label', 'source', 'for', 'settings'];

    protected $casts = [
        'for' => 'array',
        'settings' => 'array',
    ];

    public function blocks()
    {
        return $this->hasMany(ThemeTemplateBlock::class, 'template_id');
    }
}
