<?php

namespace Raakkan\OnlyLaravel\Installer\Steps;

use Exception;
use Illuminate\View\View;
use Raakkan\OnlyLaravel\Facades\OnlyLaravel;
use Raakkan\OnlyLaravel\OnlyLaravel\EnvEditor;

class WebsiteInfoStep extends Step
{
    protected $inputs = [
        'website_name' => '',
        'domain' => '',
        'purchase_code' => '',
    ];

    public static function make(): self
    {
        $step = new self;
        $step->init();

        return $step;
    }

    public function init()
    {
        // Get existing values from env if they exist
        $appName = env('APP_NAME');
        $appUrl = env('APP_URL');
        $purchaseCode = env('PURCHASE_CODE');

        if ($appName && $appUrl) {
            $this->inputs = [
                'website_name' => $appName,
                'domain' => $appUrl,
                'purchase_code' => $purchaseCode,
            ];

            return;
        }

        // Fall back to generating from request URL if env values don't exist
        $url = request()->getHost();
        $domain = $url;

        // Convert domain to website name (e.g., example-site.com -> Example Site)
        $websiteName = str_replace(['-', '.'], ' ', parse_url($url, PHP_URL_HOST) ?? $url);
        $websiteName = ucwords(preg_replace('/\.(com|net|org|etc)$/i', '', $websiteName));

        // Set the initial values
        $this->inputs = array_merge($this->inputs, [
            'website_name' => $websiteName,
            'domain' => $domain,
            'purchase_code' => $purchaseCode,
        ]);
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
            $this->saveWebsiteInfo();

            return true;
        } catch (Exception $e) {
            $this->setErrorMessage('Failed to save website information: '.$e->getMessage());

            return false;
        }
    }

    protected function saveWebsiteInfo(): void
    {
        set_time_limit(300); // 5 minutes
        ini_set('max_execution_time', 300);

        $requiredInputs = [
            'website_name' => 'Website Name',
            'domain' => 'Domain',
            'purchase_code' => 'Purchase Code',
        ];

        foreach ($requiredInputs as $field => $label) {
            if (empty($this->inputs[$field])) {
                throw new Exception("$label is required.");
            }
        }

        try {
            $key = 'base64:' . base64_encode(
                \Illuminate\Encryption\Encrypter::generateKey(config('app.cipher'))
            );

            $editor = new EnvEditor;
            $editor->set([
                'APP_NAME' => $this->inputs['website_name'],
                'APP_URL' => $this->inputs['domain'],
                'PURCHASE_CODE' => $this->inputs['purchase_code'],
                'APP_KEY' => $key
            ])->save();

            \Illuminate\Support\Facades\Artisan::call('config:clear');

            OnlyLaravel::install();
            file_put_contents(storage_path('only-laravel/installed'), 'Installation completed on '.date('Y-m-d H:i:s'));

        } catch (Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to save website information: '.$e->getMessage());
            throw $e;
        }
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
