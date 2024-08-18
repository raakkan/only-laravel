<?php

namespace Raakkan\OnlyLaravel\Models;

use Illuminate\Database\Eloquent\Model;
use Raakkan\OnlyLaravel\Facades\TemplateManager;

class TemplateModel extends Model
{
    protected $fillable = ['name', 'label', 'source', 'for_page', 'settings'];

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
        return TemplateManager::getTemplate($this->name)->setModel($this)->render();
    }
}
