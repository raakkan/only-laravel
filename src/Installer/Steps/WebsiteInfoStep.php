<?php

namespace Raakkan\OnlyLaravel\Installer\Steps;

use Illuminate\View\View;

class WebsiteInfoStep extends Step
{
    protected $inputs = [
        'website_name' => '',
        'domain' => '',
        'title' => '',
        'meta_description' => '',
        'meta_keywords' => '',
    ];

    public static function make(): self
    {
        return new self;
    }

    public function init() {}

    public function setInputs(array $inputs): self
    {
        $this->inputs = array_merge($this->inputs, $inputs);

        return $this;
    }

    public function getInputs(): array
    {
        return $this->inputs;
    }

    public function validate(): bool
    {
        // Add validation logic here if needed
        return true;
    }

    public function getTitle(): string
    {
        return 'Step 4: Website Information';
    }

    public function render(): View
    {
        return view('only-laravel::installer.steps.website-info', [
            'step' => $this,
            'inputs' => $this->inputs,
        ]);
    }
}
