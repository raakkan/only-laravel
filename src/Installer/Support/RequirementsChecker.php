<?php

namespace Raakkan\OnlyLaravel\Installer\Support;

class RequirementsChecker
{
    /**
     * Minimum PHP Version Supported (Override is in installer.php config file).
     */
    private string $minPhpVersion = '8.0.0';

    /**
     * Check for the server requirements.
     */
    public function check(array $allRequirements): array
    {
        $results = [];
        $mapMethod = [
            'php' => 'checkPhpExtensions',
            'server' => 'checkServerRequirements',
            'database' => 'checkDatabaseRequirements',
        ];

        foreach ($allRequirements as $type => $requirements) {
            if ($method = $mapMethod[$type] ?? null) {
                $results['requirements'][$type] = $this->{$method}($requirements);
            }
        }

        return $results;
    }

    public function checkPhpExtensions(array $requirements): array
    {
        $results = [];
        foreach ($requirements as $requirement) {
            $results[$requirement] = extension_loaded($requirement);
        }

        return $results;
    }

    public function checkServerRequirements(array $requirements): array
    {
        $results = [];

        if (function_exists('apache_get_modules')) {
            // Apache server
            foreach ($requirements as $module => $value) {
                $results[$module] = in_array($module, apache_get_modules());
            }
        } elseif (strpos($_SERVER['SERVER_SOFTWARE'] ?? '', 'nginx') !== false) {
            // Nginx server - assume modules are available
            foreach ($requirements as $module => $value) {
                $results[$module] = true;
            }
        } else {
            // Unknown server - try to detect features
            foreach ($requirements as $module => $value) {
                $results[$module] = match ($module) {
                    'mod_rewrite' => isset($_SERVER['REDIRECT_URL']) || isset($_SERVER['REDIRECT_STATUS']),
                    'mod_headers' => function_exists('header'),
                    default => false,
                };
            }
        }

        return $results;
    }

    public function checkDatabaseRequirements(array $requirements): array
    {
        $results = [];
        foreach ($requirements as $requirement => $value) {
            $results[$requirement] = false; // Default to false, will be updated in RequirementsStep
        }

        return $results;
    }

    /**
     * Create a new instance and perform the requirements check.
     */
    public static function make(array $requirements, ?string $minPhpVersion = null): array
    {
        $checker = new self;
        $results = $checker->check($requirements);
        $results['phpVersion'] = $checker->checkPhpVersion($minPhpVersion);

        return $results;
    }

    /**
     * Check PHP version requirement.
     */
    public function checkPhpVersion(?string $minPhpVersion = null): array
    {
        $currentPhpVersion = $this->getPhpVersionInfo();
        $minVersionPhp = $minPhpVersion ?? $this->getMinPhpVersion();
        $supported = version_compare($currentPhpVersion['version'], $minVersionPhp) >= 0;

        return [
            'full' => $currentPhpVersion['full'],
            'current' => $currentPhpVersion['version'],
            'minimum' => $minVersionPhp,
            'supported' => $supported,
        ];
    }

    /**
     * Get current Php version information.
     */
    private static function getPhpVersionInfo(): array
    {
        $currentVersionFull = PHP_VERSION;
        preg_match("#^\d+(\.\d+)*#", $currentVersionFull, $filtered);
        $currentVersion = $filtered[0];

        return [
            'full' => $currentVersionFull,
            'version' => $currentVersion,
        ];
    }

    /**
     * Get minimum PHP version.
     */
    protected function getMinPhpVersion(): string
    {
        return $this->minPhpVersion;
    }
}
