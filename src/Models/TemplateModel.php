<?php

namespace Raakkan\OnlyLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class TemplateModel extends Model
{
    protected $fillable = ['name', 'source', 'for_theme', 'for_page', 'settings'];

    protected $casts = [
        'settings' => 'array',
    ];

    public function blocks()
    {
        return $this->hasMany(TemplateBlockModel::class, 'template_id');
    }

    public function getTable(): string
    {
        return 'theme_templates';
    }
}
