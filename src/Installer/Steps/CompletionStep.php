<?php

namespace Raakkan\OnlyLaravel\Installer\Steps;

use Illuminate\View\View;

class CompletionStep extends Step
{
    public static function make(): self
    {
        return new self;
    }

    public function init() {}

    public function validate(): bool
    {
        return true;
    }

    public function getTitle(): string
    {
        return 'Installation Complete';
    }

    public function render(): View
    {
        return view('only-laravel::installer.steps.completion');
    }
}
