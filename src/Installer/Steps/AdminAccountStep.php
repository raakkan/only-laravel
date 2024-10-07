<?php

namespace Raakkan\OnlyLaravel\Installer\Steps;

use Illuminate\View\View;

class AdminAccountStep extends Step
{
    protected $adminInputs = [
        'name' => '',
        'email' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    public static function make(): self
    {
        return new self();
    }

    public function init()
    {
        $this->adminInputs = [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ];
    }

    public function setInputs(array $inputs): self
    {
        $this->adminInputs = array_merge($this->adminInputs, $inputs);
        return $this;
    }

    public function getInputs(): array
    {
        return $this->adminInputs;
    }

    public function validate(): bool
    {
        // Add your validation logic here
        // For now, we'll just check if all fields are filled
        foreach ($this->adminInputs as $value) {
            if (empty($value)) {
                $this->setErrorMessage('All fields are required.');
                return false;
            }
        }

        if ($this->adminInputs['password'] !== $this->adminInputs['password_confirmation']) {
            $this->setErrorMessage('Passwords do not match.');
            return false;
        }

        return true;
    }

    public function getTitle(): string
    {
        return 'Step 4: Create Admin Account';
    }

    public function render(): View
    {
        return view('only-laravel::installer.steps.admin-account', [
            'step' => $this,
            'inputs' => $this->adminInputs,
        ]);
    }
}