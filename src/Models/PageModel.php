<?php

namespace Raakkan\OnlyLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Raakkan\OnlyLaravel\Models\TemplateModel;
use Raakkan\OnlyLaravel\Template\PageTemplate;

class PageModel extends Model
{
    protected $fillable = ['name', 'title', 'slug', 'content', 'template_id', 'settings', 'indexable', 'disabled'];

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

    public function getPageTemplate()
    {
        $template = PageTemplate::make($this->template->name);
        $template->setPageModel($this)->initializeFromCachedModel($this->template);
        return $template;
    }

    public static function getAccessebleAttributes()
    {
        return [
            'name' => 'Name',
            'title' => 'Title',
            'slug' => 'Slug',
            'content' => 'Content',
        ];
    }

    public function getTable(): string
    {
        return 'pages';
    }
}
