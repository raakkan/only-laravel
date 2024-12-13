<?php

namespace Raakkan\OnlyLaravel\Installer\Steps;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Raakkan\OnlyLaravel\OnlyLaravel\EnvEditor;

class DatabaseStep extends Step
{
    public $inputs = [
        'db_connection' => 'mysql',
        'db_host' => '',
        'db_port' => '',
        'db_database' => '',
        'db_username' => '',
        'db_password' => '',
    ];

    public static function make(): self
    {
        $step = new self;
        $step->init();

        return $step;
    }

    public function init()
    {
        $this->inputs = [
            'db_connection' => env('DB_CONNECTION', 'mysql'),
            'db_host' => env('DB_HOST', ''),
            'db_port' => env('DB_PORT', ''),
            'db_database' => env('DB_DATABASE', ''),
            'db_username' => env('DB_USERNAME', ''),
            'db_password' => env('DB_PASSWORD', ''),
        ];
    }

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
        try {
            $this->checkConnection();
            Artisan::call('migrate');

            return true;
        } catch (Exception $e) {
            $this->setErrorMessage('Database connection failed: '.$e->getMessage());

            return false;
        }
    }

    protected function checkConnection(): void
    {
        // Only validate inputs if they've changed from current env values
        if ($this->isCurrentEnvConnection()) {
            return;
        }

        $requiredInputs = [
            'db_connection' => 'Database Connection',
            'db_host' => 'Database Host',
            'db_port' => 'Database Port',
            'db_database' => 'Database Name',
            'db_username' => 'Database Username',
        ];

        foreach ($requiredInputs as $field => $label) {
            if (empty($this->inputs[$field])) {
                throw new Exception("$label is required.");
            }
        }

        try {
            $editor = new EnvEditor;
            $editor->set([
                'DB_CONNECTION' => $this->inputs['db_connection'],
                'DB_HOST' => $this->inputs['db_host'],
                'DB_PORT' => $this->inputs['db_port'],
                'DB_DATABASE' => $this->inputs['db_database'],
                'DB_USERNAME' => $this->inputs['db_username'],
                'DB_PASSWORD' => $this->inputs['db_password'],
            ])->save();

            DB::reconnect('mysql');
            DB::connection()->getPdo();
        } catch (Exception $e) {
            \Illuminate\Support\Facades\Log::error('Database connection failed: '.$e->getMessage());
            throw $e;
        }
    }

    protected function isCurrentEnvConnection(): bool
    {
        return $this->inputs['db_connection'] === env('DB_CONNECTION')
            && $this->inputs['db_host'] === env('DB_HOST')
            && $this->inputs['db_port'] === env('DB_PORT')
            && $this->inputs['db_database'] === env('DB_DATABASE')
            && $this->inputs['db_username'] === env('DB_USERNAME')
            && $this->inputs['db_password'] === env('DB_PASSWORD');
    }

    public function getTitle(): string
    {
        return 'Step 3: Database Configuration';
    }

    public function render(): View
    {
        return view('only-laravel::installer.steps.database', [
            'step' => $this,
            'inputs' => $this->inputs,
        ]);
    }
}
