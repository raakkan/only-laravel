<?php

namespace Raakkan\OnlyLaravel\Installer\Steps;

use Illuminate\View\View;
use Raakkan\OnlyLaravel\Installer\Support\RequirementsChecker;

class RequirementsStep extends Step
{
    protected array $requirements;

    protected array $phpVersion;

    public static function make(): self
    {
        $step = new self;
        $step->init();

        return $step;
    }

    public function init()
    {
        $requirements = [
            'php' => [
                'ctype',
                'curl',
                'fileinfo',
                'json',
                'mbstring',
                'openssl',
                'pdo',
                'pdo_mysql',
                'tokenizer',
                'xml',
            ],
            'server' => [
                'mod_rewrite' => false,
                'mod_headers' => false,
            ],
            'database' => [
                'mysql' => false,
            ]
        ];
        $minPhpVersion = '8.3.0';

        $results = RequirementsChecker::make($requirements, $minPhpVersion);

        $results['requirements']['php']['image_library'] = extension_loaded('gd') || extension_loaded('imagick');
        $results['requirements']['php']['allow_url_fopen'] = ini_get('allow_url_fopen');

        if (extension_loaded('pdo_mysql')) {
            try {
                $pdo = new \PDO('mysql:host=' . config('database.connections.mysql.host'), 
                    config('database.connections.mysql.username'),
                    config('database.connections.mysql.password')
                );
                $version = $pdo->query('SELECT VERSION()')->fetchColumn();
                $results['requirements']['database']['mysql'] = 
                    version_compare($version, '5.7.0', '>=') || 
                    (str_contains(strtolower($version), 'mariadb') && version_compare($version, '10.3.0', '>='));
            } catch (\Exception $e) {
                $results['requirements']['database']['mysql'] = false;
            }
        }

        if (!isset($results['requirements']['server'])) {
            $results['requirements']['server'] = [
                'mod_rewrite' => false,
                'mod_headers' => false,
            ];
        }

        if (function_exists('apache_get_modules')) {
            $results['requirements']['server']['mod_rewrite'] = in_array('mod_rewrite', apache_get_modules());
            $results['requirements']['server']['mod_headers'] = in_array('mod_headers', apache_get_modules());
        } elseif (strpos($_SERVER['SERVER_SOFTWARE'] ?? '', 'nginx') !== false) {
            $results['requirements']['server']['mod_rewrite'] = true;
            $results['requirements']['server']['mod_headers'] = true;
        } else {
            $results['requirements']['server']['mod_rewrite'] = isset($_SERVER['REDIRECT_URL']) || isset($_SERVER['REDIRECT_STATUS']);
            $results['requirements']['server']['mod_headers'] = function_exists('header');
        }

        $this->requirements = $results;
        $this->phpVersion = $results['phpVersion'];
    }

    public function validate(): bool
    {
        $allRequirementsMet = true;
        $errors = [];

        foreach ($this->requirements['requirements'] as $type => $requirements) {
            foreach ($requirements as $requirement => $met) {
                if (! $met) {
                    $allRequirementsMet = false;
                    $errors[] = match ($requirement) {
                        'image_library' => 'Either GD or Imagick PHP extension is required.',
                        'allow_url_fopen' => 'The allow_url_fopen setting must be enabled in PHP.',
                        'mod_rewrite' => 'Web server rewrite module is required (mod_rewrite for Apache or ngx_http_rewrite_module for Nginx).',
                        'mod_headers' => 'Web server headers module is required (mod_headers for Apache or ngx_http_headers_module for Nginx).',
                        'mysql' => 'MySQL 5.7+ or MariaDB 10.3+ is required.',
                        default => "The {$requirement} {$type} requirement is not met.",
                    };
                }
            }
        }

        $phpVersionSupported = $this->requirements['phpVersion']['supported'];
        if (! $phpVersionSupported) {
            $allRequirementsMet = false;
            $errors[] = 'PHP 8.3 or higher is required.';
        }

        if (! $allRequirementsMet) {
            $this->setErrorMessage(implode(' ', $errors));
        }

        return $allRequirementsMet;
    }

    public function getTitle(): string
    {
        return 'Step 1: Server Requirements';
    }

    public function render(): View
    {
        return view('only-laravel::installer.steps.requirements', [
            'step' => $this,
            'requirements' => $this->requirements['requirements'],
            'phpVersion' => $this->phpVersion,
        ]);
    }
}
