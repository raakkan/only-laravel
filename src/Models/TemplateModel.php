<?php

namespace Raakkan\OnlyLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Raakkan\OnlyLaravel\Facades\TemplateManager;

class TemplateModel extends Model
{
    protected $fillable = ['name', 'label', 'source', 'for_page', 'for_page_type', 'settings'];

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
        return TemplateManager::getTemplate($this->name)->setCachedModel($this->load('blocks'))->render();
    }

    // return Cache::remember('template_' . $this->id, $this->cache_ttl, function () {
    //     return TemplateManager::getTemplate($this->name)->setModel($this->load('blocks'))->render();
    // });
}
