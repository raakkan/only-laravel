<?php

namespace Raakkan\OnlyLaravel\Installer\Steps;

use Illuminate\View\View;

interface StepInterface
{
    public static function make();
    public function init();
    public function validate(): bool;
    public function getTitle(): string;
    public function render(): View;
}