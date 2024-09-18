<?php

namespace Raakkan\OnlyLaravel\Models;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\SoftDeletes;
use Raakkan\OnlyLaravel\Models\TemplateModel;
use Raakkan\OnlyLaravel\Template\PageTemplate;
use Raakkan\OnlyLaravel\Support\Concerns\HasSeoTags;

class PageModel extends Model
{
    use SoftDeletes;
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
        if (isset($this->featured_image['image']) && File::exists(storage_path('app/public/' . $this->featured_image['image']))) {
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

    public static function createWithData($data)
    {
        $model = new static;
        $model->name = $data['name'];
        $model->title = $data['title'];
        $model->slug = $data['slug'];
        $model->content = $data['content'];
        $model->template_id = $data['template_id'];
        $model->settings = $data['settings'];
        $model->indexable = $data['indexable'];
        $model->disabled = $data['disabled'];
        $model->seo_title = $data['seo_title'];

        return $model;
    }

    public static function findBySlug($slug)
    {
        $driver = \DB::getDriverName();

        $query = static::query()->with('template.blocks');

        switch ($driver) {
            case 'mysql':
            case 'mariadb':
                return $query->where(function($q) use ($slug) {
                    $q->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$." . app()->getLocale() . "')) = ?", [$slug])
                    ->orWhereRaw("JSON_UNQUOTE(JSON_EXTRACT(slug, '$.en')) = ?", [$slug]);
                })->first();
            case 'pgsql':
                return $query->where(function($q) use ($slug) {
                    $q->where("slug->>'" . app()->getLocale() . "'", $slug)
                    ->orWhere("slug->>'en'", $slug);
                })->first();
            case 'sqlsrv':
                return $query->where(function($q) use ($slug) {
                    $q->where("JSON_VALUE(slug, '$." . app()->getLocale() . "')", $slug)
                    ->orWhere("JSON_VALUE(slug, '$.en')", $slug);
                })->first();
            default:
                throw new \Exception("Unsupported database driver: {$driver}");
        }
    }

    public function setPageType($pageType)
    {
        $this->pageType = $pageType;
        return $this;
    }

    public function setPageTypeLevel($pageTypeLevel)
    {
        $this->pageTypeLevel = $pageTypeLevel;
        return $this;
    }

    public function getPageType()
    {
        return $this->pageType;
    }

    public function getPageTypeLevel()
    {
        return $this->pageTypeLevel;
    }

    public function getSlugUrl()
    {
        $pageType = app('page-manager')->findPageTypeByType($this->pageType);
        
        if ($this->name == 'home-page') {
            return url('/');
        }

        if ($pageType) {
            return $pageType->generateUrl($this->slug);
        }

        return url($this->slug);
    }
}
