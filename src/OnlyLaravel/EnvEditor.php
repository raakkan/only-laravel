<?php

namespace Raakkan\OnlyLaravel\OnlyLaravel;

class EnvEditor
{
    private string $envPath;

    private array $env = [];

    private bool $backup = false;

    private string $backupPath;

    public function __construct(?string $envPath = null, bool $backup = false)
    {
        $this->envPath = $envPath ?? $this->getDefaultEnvPath();
        $this->backup = $backup;
        $this->backupPath = dirname($this->envPath).'/backups';
        $this->load();
    }

    /**
     * Get default .env file path
     */
    private function getDefaultEnvPath(): string
    {
        // Check if Laravel's base_path() is available
        if (function_exists('base_path')) {
            return base_path('.env');
        }

        // Fallback to current directory
        return getcwd().DIRECTORY_SEPARATOR.'.env';
    }

    /**
     * Load and parse the .env file
     */
    private function load(): void
    {
        if (! file_exists($this->envPath)) {
            throw new \RuntimeException("Env file not found at: {$this->envPath}");
        }

        $content = file_get_contents($this->envPath);
        $lines = explode("\n", $content);

        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line) || str_starts_with($line, '#')) {
                continue;
            }

            $parts = explode('=', $line, 2);
            if (count($parts) !== 2) {
                continue;
            }

            $key = trim($parts[0]);
            $value = trim($parts[1]);

            // Remove quotes if present
            $value = trim($value, '"\'');

            $this->env[$key] = $value;
        }
    }

    /**
     * Get value for a key
     */
    public function get(string $key): ?string
    {
        return $this->env[$key] ?? null;
    }

    /**
     * Set value for a key
     */
    public function set(string|array $key, ?string $value = null): self
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->env[$k] = $v;
            }
        } else {
            $this->env[$key] = $value;
        }

        return $this;
    }

    /**
     * Remove a key
     */
    public function remove(string $key): self
    {
        unset($this->env[$key]);

        return $this;
    }

    /**
     * Get all environment variables
     */
    public function all(): array
    {
        return $this->env;
    }

    /**
     * Create backup before saving
     */
    private function backup(): void
    {
        if (! $this->backup) {
            return;
        }

        if (! is_dir($this->backupPath)) {
            mkdir($this->backupPath, 0755, true);
        }

        $backupFile = $this->backupPath.'/.env.'.date('Y-m-d-His');
        copy($this->envPath, $backupFile);
    }

    /**
     * Save changes back to .env file
     */
    public function save(): bool
    {
        if ($this->backup) {
            $this->backup();
        }

        $content = '';
        foreach ($this->env as $key => $value) {
            // Add quotes if value contains spaces
            if (str_contains($value, ' ')) {
                $value = '"'.$value.'"';
            }
            $content .= "{$key}={$value}\n";
        }

        return file_put_contents($this->envPath, $content) !== false;
    }
}
