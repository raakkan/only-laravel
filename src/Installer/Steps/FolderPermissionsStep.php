<?php

namespace Raakkan\OnlyLaravel\Installer\Steps;

use Illuminate\View\View;

class FolderPermissionsStep extends Step
{
    protected array $folders;

    public static function make(): self
    {
        $step = new self;
        $step->init();

        return $step;
    }

    public function init()
    {
        $this->folders = [
            'storage/onlylaravel' => $this->isWritable(storage_path('onlylaravel')),
            'storage/app' => $this->isWritable(storage_path('app')),
            'storage/framework' => $this->isWritable(storage_path('framework')),
            'storage/logs' => $this->isWritable(storage_path('logs')),
            'bootstrap/cache' => $this->isWritable(base_path('bootstrap/cache')),
        ];
    }

    protected function isWritable(string $path): bool
    {
        return is_writable($path);
    }

    public function validate(): bool
    {
        $allFoldersWritable = true;
        $errors = [];

        foreach ($this->folders as $folder => $isWritable) {
            if (! $isWritable) {
                $allFoldersWritable = false;
                $errors[] = "The {$folder} folder is not writable.";
            }
        }

        if (! $allFoldersWritable) {
            $this->setErrorMessage(implode(' ', $errors));
        }

        return $allFoldersWritable;
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
        ]);
    }
}
