<?php

namespace Raakkan\OnlyLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Raakkan\OnlyLaravel\Models\TemplateModel;

class PageModel extends Model
{
    protected $fillable = ['name', 'title', 'slug', 'content', 'template_id', 'settings', 'indexable', 'disabled', 'page_type'];

    protected $casts = [
        'settings' => 'array',
        'indexable' => 'boolean',
        'disabled' => 'boolean',
    ];

    public function template()
    {
        return $this->belongsTo(TemplateModel::class, 'template_id');
    }

    public static function getRegisteredPageTypes()
    {
        return self::all()->pluck('page_type')->unique()->toArray();
    }

    public function getTable(): string
    {
        return 'pages';
    }
}
