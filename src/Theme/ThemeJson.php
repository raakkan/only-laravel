<?php

namespace Raakkan\OnlyLaravel\Theme;

use Illuminate\Support\Facades\File;

class ThemeJson
{
    protected array $data;

    protected string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->data = $this->load();
    }

    protected function load(): array
    {
        if (! File::exists($this->path)) {
            return [];
        }

        $content = File::get($this->path);

        return json_decode($content, true) ?? [];
    }

    public function isValid(): bool
    {
        return ! empty($this->data) && isset($this->data['name']);
    }

    public function getName(): string
    {
        return $this->data['name'] ?? '';
    }

    public function getLabel(): string
    {
        return $this->data['label'] ?? $this->getName();
    }

    public function getVersion(): string
    {
        return $this->data['version'] ?? '1.0.0';
    }

    public function getDescription(): string
    {
        return $this->data['description'] ?? '';
    }

    public function getSettings(): array
    {
        return $this->data['settings'] ?? [];
    }

    public function getScreenshot(): string
    {
        return $this->data['screenshot'] ?? '';
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'label' => $this->getLabel(),
            'version' => $this->getVersion(),
            'description' => $this->getDescription(),
            'settings' => $this->getSettings(),
            'screenshot' => $this->getScreenshot(),
        ];
    }
}
