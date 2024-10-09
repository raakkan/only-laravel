<?php

namespace Raakkan\OnlyLaravel\Installer\Steps;

use Illuminate\View\View;
use Illuminate\Support\Facades\File;

class EnvConfigStep extends Step
{
    protected $envPath;
    protected $isEnvWritable;
    protected $envContent;

    public static function make(): self
    {
        $step = new self();
        $step->init();
        return $step;
    }

    public function init()
    {
        $this->envPath = base_path('.env');
        $this->isEnvWritable = is_writable(dirname($this->envPath)) && (!file_exists($this->envPath) || is_writable($this->envPath));
        $this->envContent = $this->getEnvContent();
    }

    public function validate(): bool
    {
        if ($this->isEnvWritable) {
            return $this->writeEnvFile();
        }
        return true; // Always return true, as we'll show manual instructions if not writable
    }

    protected function writeEnvFile(): bool
    {
        try {
            File::put($this->envPath, $this->envContent);
            return true;
        } catch (\Exception $e) {
            $this->setErrorMessage("Failed to write .env file: " . $e->getMessage());
            return false;
        }
    }

    protected function getEnvContent(): string
    {
        // Replace this with your actual .env template or generation logic
        return "APP_NAME=Laravel
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

# ... Add other necessary configurations ...
";
    }

    public function getTitle(): string
    {
        return 'Step 2: Environment Configuration';
    }

    public function render(): View
    {
        return view('only-laravel::installer.steps.env-config', [
            'step' => $this,
            'isEnvWritable' => $this->isEnvWritable,
            'envContent' => $this->envContent,
        ]);
    }
}