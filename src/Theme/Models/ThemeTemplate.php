<?php

namespace Raakkan\OnlyLaravel\Theme\Models;

use Illuminate\Database\Eloquent\Model;

class ThemeTemplate extends Model
{
    protected $fillable = ['name', 'source', 'for_theme', 'for_page', 'settings'];

    protected $casts = [
        'settings' => 'array',
    ];

    public function blocks()
    {
        return $this->hasMany(ThemeTemplateBlock::class, 'template_id');
    }

    public function getTable(): string
    {
        return 'theme_templates';
    }
}
