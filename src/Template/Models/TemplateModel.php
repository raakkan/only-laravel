<?php

namespace Raakkan\OnlyLaravel\Template\Models;

use Illuminate\Database\Eloquent\Model;
use Raakkan\OnlyLaravel\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Template\PageTemplate;

class TemplateModel extends Model
{
    protected $fillable = [
        'name',
        'label',
        'type',
        'settings',
        'is_parent',
        'use_parent_header',
        'use_parent_content',
        'use_parent_footer',
        'parent_template_id',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_parent' => 'boolean',
        'use_parent_header' => 'boolean',
        'use_parent_content' => 'boolean',
        'use_parent_footer' => 'boolean',
    ];

    public function blocks()
    {
        return $this->hasMany(TemplateBlockModel::class, 'template_id');
    }

    public function getTable(): string
    {
        return 'templates';
    }

    public function getPageTemplate()
    {
        $template = PageTemplate::make($this->name);
        $template->initializeFromCachedModel($this);

        return $template;
    }

    public function getContainerCssClasses()
    {
        return $this->settings['onlylaravel']['container_css_classes'] ?? '';
    }

    public function parentTemplate()
    {
        return $this->belongsTo(TemplateModel::class, 'parent_template_id');
    }

    public function childTemplates()
    {
        return $this->hasMany(TemplateModel::class, 'parent_template_id');
    }

    // return Cache::remember('template_' . $this->id, $this->cache_ttl, function () {
    //     return TemplateManager::getTemplate($this->name)->setModel($this->load('blocks'))->render();
    // });
}
