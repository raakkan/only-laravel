<?php

namespace Raakkan\OnlyLaravel\Installer\Steps;

use Illuminate\View\View;
use Raakkan\OnlyLaravel\Installer\Livewire\Installer;

abstract class Step implements StepInterface
{
    protected $errorMessage = '';

    abstract public function init();
    abstract public static function make();
    abstract public function validate(): bool;
    abstract public function getTitle(): string;
    abstract public function render(): View;

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    protected function setErrorMessage(string $message): void
    {
        $this->errorMessage = $message;
    }
}