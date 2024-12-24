<?php

namespace Raakkan\OnlyLaravel\Installer\Steps;

use Illuminate\View\View;

class FolderPermissionsStep extends Step
{
    protected array $folders;

    protected array $files;

    public static function make(): self
    {
        $step = new self;
        $step->init();

        return $step;
    }

    public function init()
    {
        $this->folders = [
            'storage/app/public' => $this->isWritable(storage_path('app/public')),
            'storage/framework' => $this->isWritable(storage_path('framework')),
            'storage/logs' => $this->isWritable(storage_path('logs')),
            'bootstrap/cache' => $this->isWritable(base_path('bootstrap/cache')),
            'storage/only-laravel' => $this->isWritable(storage_path('only-laravel')),
            'public' => $this->isWritable(public_path()),
        ];

        $this->files = [
            '.env' => $this->isWritable(base_path('.env')),
        ];
    }

    protected function isWritable(string $path): bool
    {
        return is_writable($path);
    }

    public function validate(): bool
    {
        $allWritable = true;
        $errors = [];

        foreach ($this->folders as $folder => $isWritable) {
            if (! $isWritable) {
                $allWritable = false;
                $errors[] = "The {$folder} folder is not writable.";
            }
        }

        foreach ($this->files as $file => $isWritable) {
            if (! $isWritable) {
                $allWritable = false;
                $errors[] = "The {$file} file is not writable.";
            }
        }

        if (! $allWritable) {
            $this->setErrorMessage(implode(' ', $errors));
        }

        return $allWritable;
    }

    public function getTitle(): string
    {
        return 'Step 2: Folder Permissions';
    }

    public function render(): View
    {
        return view('only-laravel::installer.steps.folder-permissions', [
            'step' => $this,
            'folders' => $this->folders,
            'files' => $this->files,
        ]);
    }
}
