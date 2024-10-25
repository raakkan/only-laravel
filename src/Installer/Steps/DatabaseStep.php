<?php

namespace Raakkan\OnlyLaravel\Installer\Steps;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DatabaseStep extends Step
{
    protected $dbInputs = [
        'db_connection' => '',
        'db_host' => '',
        'db_port' => '',
        'db_database' => '',
        'db_username' => '',
        'db_password' => '',
    ];

    public static function make(): self
    {
        return new self;
    }

    public function init() {}

    public function setInputs(array $inputs): self
    {
        $this->dbInputs = array_merge($this->dbInputs, $inputs);

        return $this;
    }

    public function getInputs(): array
    {
        return $this->dbInputs;
    }

    public function validate(): bool
    {
        try {
            $this->checkConnection();

            return true;
        } catch (Exception $e) {
            $this->setErrorMessage('Database connection failed: '.$e->getMessage());

            return false;
        }
    }

    protected function checkConnection(): void
    {
        config([
            'database.connections.installer_test' => [
                'driver' => $this->dbInputs['db_connection'],
                'host' => $this->dbInputs['db_host'],
                'port' => $this->dbInputs['db_port'],
                'database' => $this->dbInputs['db_database'],
                'username' => $this->dbInputs['db_username'],
                'password' => $this->dbInputs['db_password'],
            ],
        ]);

        DB::connection('installer_test')->getPdo();
    }

    public function getTitle(): string
    {
        return 'Step 3: Database Configuration';
    }

    public function render(): View
    {
        return view('only-laravel::installer.steps.database', [
            'step' => $this,
            'inputs' => $this->dbInputs,
        ]);
    }
}
