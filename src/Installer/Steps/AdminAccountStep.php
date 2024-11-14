<?php

namespace Raakkan\OnlyLaravel\Installer\Steps;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

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
        $step = new self;
        $step->init();

        return $step;
    }

    public function init()
    {
        if ($this->isDbConnected()) {
            $superAdmin = \App\Models\User::role('super_admin')->first();
        }
        
        $this->adminInputs = [
            'name' => $superAdmin?->name ?? '',
            'email' => $superAdmin?->email ?? '',
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
        if (\App\Models\User::role('super_admin')->exists()) {
            if (!empty($this->adminInputs['password'])) {
                if ($this->adminInputs['password'] !== $this->adminInputs['password_confirmation']) {
                    $this->setErrorMessage('Passwords do not match.');
                    return false;
                }
                $this->process();
            }
            return true;
        }

        foreach ($this->adminInputs as $key => $value) {
            if (empty($value)) {
                $this->setErrorMessage('All fields are required.');
                return false;
            }
        }

        if ($this->adminInputs['password'] !== $this->adminInputs['password_confirmation']) {
            $this->setErrorMessage('Passwords do not match.');
            return false;
        }

        if (!filter_var($this->adminInputs['email'], FILTER_VALIDATE_EMAIL)) {
            $this->setErrorMessage('Please enter a valid email address.');
            return false;
        }

        $this->process();

        return true;
    }

    public function process(): bool
    {
        try {
            $superAdmin = \App\Models\User::role('super_admin')->first();
            
            if ($superAdmin && !empty($this->adminInputs['password'])) {
                $superAdmin->update([
                    'password' => bcrypt($this->adminInputs['password'])
                ]);
                return true;
            }

            $user = \App\Models\User::firstOrCreate(
                ['email' => $this->adminInputs['email']],
                [
                    'name' => $this->adminInputs['name'],
                    'password' => bcrypt($this->adminInputs['password']),
                    'email_verified_at' => now(),
                ]
            );

            if (!$user->hasRole('super_admin')) {
                $user->assignRole('super_admin');
            }

            return true;
        } catch (\Exception $e) {
            $this->setErrorMessage('Failed to create admin account: ' . $e->getMessage());
            return false;
        }
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

    public function isDbConnected(): bool
    {
        try {
            $pdo = DB::connection()->getPdo();
            $usersExist = DB::getSchemaBuilder()->hasTable('users');
            $rolesExist = DB::getSchemaBuilder()->hasTable('roles');
            return $pdo && $usersExist && $rolesExist;
        } catch (\Exception $e) {
            return false;
        }
    }
}
