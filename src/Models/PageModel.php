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
        // Try to get from cache first
        $cacheKey = "page_slug_{$slug}";
        
        // If found in cache, return immediately
        if ($cachedPage = cache($cacheKey)) {
            return $cachedPage;
        }

        $query = static::query()->with(['template.blocks' => function ($query) {
            $query->orderBy('order', 'asc');
        }, 'template.parentTemplate.blocks' => function ($query) {
            $query->orderBy('order', 'asc');
        }]);

        $page = $query->where('slug', $slug)->first();

        // Only cache if page is found
        if ($page) {
            cache()->put($cacheKey, $page, now()->addHours(24));
        }

        return $page;
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
