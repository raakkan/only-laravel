<?php

namespace Raakkan\OnlyLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Raakkan\OnlyLaravel\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Template\PageTemplate;

class TemplateModel extends Model
{
    protected $fillable = ['name', 'label', 'source', 'for', 'type', 'settings'];

    protected $casts = [
        'settings' => 'array',
    ];

    public function blocks()
    {
        return $this->hasMany(TemplateBlockModel::class, 'template_id');
    }

    public function getTable(): string
    {
        return 'templates';
    }

    public function render()
    {
        $template = PageTemplate::make($this->name);
        $template->setCachedModel($this->load('blocks'));
        return $template->render();
    }

    // return Cache::remember('template_' . $this->id, $this->cache_ttl, function () {
    //     return TemplateManager::getTemplate($this->name)->setModel($this->load('blocks'))->render();
    // });
}
