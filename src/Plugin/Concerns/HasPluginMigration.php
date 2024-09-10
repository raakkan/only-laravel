<?php

namespace Raakkan\OnlyLaravel\Plugin\Concerns;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

trait HasPluginMigration
{
    public function migrate()
    {
        $migrationPath = $this->path . '/database/migrations';

        if (is_dir($migrationPath)) {
            $migrationFiles = glob($migrationPath . '/*.php');
            foreach ($migrationFiles as $file) {
                if (File::exists($file)) {
                    if (!$this->migrationTableExists($file)) {
                        $this->runMigrationUp($file);
                    }
                }
            }
        }
    }

    public function rollback()
    {
        $migrationPath = $this->path . '/database/migrations';

        if (is_dir($migrationPath)) {
            $migrationFiles = glob($migrationPath . '/*.php');
            foreach ($migrationFiles as $file) {
                if (File::exists($file)) {
                    if ($this->migrationTableExists($file)) {
                        $this->runMigrationDown($file);
                    }
                }
            }
        }
    }

    protected function migrationTableExists($migrationFile)
    {
        $tableName = $this->getTableNameFromMigrationFile($migrationFile);
        return Schema::hasTable($tableName);
    }

    protected function getTableNameFromMigrationFile($migrationFile)
    {
        $fileName = basename($migrationFile, '.php');
        $parts = explode('_', $fileName);
        $tableName = '';

        foreach ($parts as $part) {
            if (str_contains($part, 'create') || str_contains($part, 'update')) {
                continue;
            }

            if (str_contains($part, 'table')) {
                break;
            }

            $tableName .= '_' . $part;
        }

        return ltrim($tableName, '_');
    }

    protected function runMigrationUp($migrationFile)
    {
        $migrationClass = require $migrationFile;
        $migrationInstance = new $migrationClass;
        $migrationInstance->up();
    }

    protected function runMigrationDown($migrationFile)
    {
        $migrationClass = require $migrationFile;
        $migrationInstance = new $migrationClass;
        $migrationInstance->down();
    }
}