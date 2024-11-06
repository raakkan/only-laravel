<?php

namespace Raakkan\OnlyLaravel\Plugin\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Raakkan\OnlyLaravel\Plugin\PluginJson;

class PluginModel extends Model
{
    use SoftDeletes;

    protected $table = 'plugins';

    protected $fillable = [
        'name',
        'label',
        'version',
        'description',
        'is_active',
        'settings',
        'update_available',
        'custom_data',
        'requirements_status',
        'requirements_checked_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'update_available' => 'boolean',
        'settings' => 'array',
        'custom_data' => 'array',
        'requirements_status' => 'array',
        'requirements_checked_at' => 'datetime',
    ];

    public function activate(): bool
    {
        $activated = $this->update(['is_active' => true]);
        cache()->forget('active_plugins');
        return $activated;
    }

    public static function activePlugins()
    {
        return cache()->rememberForever('active_plugins', function () {
            return static::where('is_active', true)->get();
        });
    }

    public function updatePlugin(): bool
    {
        $latestVersion = $this->getPluginJson()->getVersion();
        if ($latestVersion > $this->version) {
            return $this->update(['update_available' => false, 'version' => $latestVersion]);
        }

        return false;
    }

    public function getPluginJson(): ?PluginJson
    {
        return new PluginJson(app('plugin-manager')->getPluginPath($this->name).'/plugin.json');
    }

    public function hasUpdate(): bool
    {
        return $this->update_available;
    }

    public function getLatestVersion(): string
    {
        return $this->getPluginJson()->getVersion();
    }
} 