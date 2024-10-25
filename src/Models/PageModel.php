<?php

namespace Raakkan\OnlyLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Raakkan\OnlyLaravel\Page\Concerns\HasSeoTags;
use Raakkan\OnlyLaravel\Template\Models\TemplateModel;
use Raakkan\OnlyLaravel\Template\PageTemplate;
use Spatie\Translatable\HasTranslations;

class PageModel extends Model
{
    use HasSeoTags;
    use HasTranslations;
    use SoftDeletes;

    public $translatable = ['title', 'subtitle', 'slug', 'content', 'seo_title', 'seo_description', 'seo_keywords'];

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
        return $this->belongsTo(TemplateModel::class, 'template_id')->required();
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
        if (isset($this->featured_image['image']) && File::exists(storage_path('app/public/'.$this->featured_image['image']))) {
            return url(Storage::url($this->featured_image['image']));
        }

        return null;
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
        $query = static::query()->with('template.blocks');
        $locale = app()->getLocale();
        $driver = \DB::getDriverName();

        switch ($driver) {
            case 'mysql':
                return $query->where(function ($q) use ($slug, $locale) {
                    $q->where("slug->{$locale}", $slug)
                        ->orWhere('slug->en', $slug)
                        ->orWhere('slug', $slug); // For non-JSON slugs
                })->first();
            case 'mariadb':
                return $query->where(function ($q) use ($slug, $locale) {
                    $q->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.{$locale}')) = ?", [$slug])
                        ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.en')) = ?", [$slug])
                        ->orWhere('slug', $slug); // For non-JSON slugs
                })->first();
            case 'pgsql':
                return $query->where(function ($q) use ($slug, $locale) {
                    $q->where("slug->>'{$locale}'", $slug)
                        ->orWhere("slug->>'en'", $slug)
                        ->orWhere('slug', $slug); // For non-JSON slugs
                })->first();
            case 'sqlsrv':
                return $query->where(function ($q) use ($slug, $locale) {
                    $q->where("JSON_VALUE(slug, '$.{$locale}')", $slug)
                        ->orWhere("JSON_VALUE(slug, '$.en')", $slug)
                        ->orWhere('slug', $slug); // For non-JSON slugs
                })->first();
            case 'sqlite':
                // SQLite doesn't have native JSON functions, so we'll use a simple comparison
                return $query->where('slug', $slug)->first();
            default:
                throw new \Exception("Unsupported database driver: {$driver}");
        }
    }

    // public function getSlugUrl()
    // {
    //     $pageType = app('page-manager')->findPageTypeByType($this->pageType);

    //     if ($this->name == 'home-page') {
    //         return url('/');
    //     }

    //     if ($pageType) {
    //         return $pageType->generateUrl($this->slug);
    //     }

    //     return url($this->slug);
    // }
}
