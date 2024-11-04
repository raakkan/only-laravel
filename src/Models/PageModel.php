<?php

namespace Raakkan\OnlyLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Raakkan\OnlyLaravel\Page\Concerns\HasSeoTags;
use Raakkan\OnlyLaravel\Template\Models\TemplateModel;
use Raakkan\OnlyLaravel\Template\PageTemplate;
use Spatie\Translatable\HasTranslations;

class PageModel extends Model
{
    use HasSeoTags;
    use HasTranslations;

    public $translatable = ['title', 'subtitle', 'content', 'seo_title', 'seo_description', 'seo_keywords'];

    protected $fillable = [
        'name',
        'title',
        'subtitle',
        'slug',
        'content',
        'template_id',
        'settings',
        'disabled',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'featured_image',
    ];

    protected $casts = [
        'settings' => 'array',
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

    public function getName()
    {
        return $this->name;
    }

    public static function findBySlug($slug)
    {
        $query = static::query()->with(['template.blocks' => function ($query) {
            $query->orderBy('order', 'asc');
        }, 'template.parentTemplate.blocks' => function ($query) {
            $query->orderBy('order', 'asc');
        }]);

        return $query->where('slug', $slug)->first();
    }

    public function getMenuGroup()
    {
        return 'Pages';
    }

    public function generateUrl()
    {
        return url($this->slug);
    }
}
