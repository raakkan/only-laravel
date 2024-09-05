<?php

namespace Raakkan\OnlyLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;
use Raakkan\OnlyLaravel\Models\TemplateModel;
use Raakkan\OnlyLaravel\Template\PageTemplate;
use Raakkan\OnlyLaravel\Support\Concerns\HasSeoTags;

class PageModel extends Model
{
    use HasTranslations;
    use HasSeoTags;
    protected $pageType = 'pages';
    protected $pageTypeLevel = 'root';
    public $translatable = ['title', 'slug', 'content', 'seo_title', 'seo_description', 'seo_keywords'];
    protected $fillable = ['name', 'title', 'slug', 'content', 'template_id', 'settings', 'indexable', 'disabled', 'seo_title', 'seo_description', 'seo_keywords', 'featured_image'];

    protected $casts = [
        'settings' => 'array',
        'indexable' => 'boolean',
        'disabled' => 'boolean',
        'featured_image' => 'array',
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

    public function getFeaturedImageUrl(): ?string
    {
        if (isset($this->featured_image['image'])) {
            return url(Storage::url($this->featured_image['image']));
        }
        return null;
    }

    public function getTable(): string
    {
        return 'pages';
    }
}
