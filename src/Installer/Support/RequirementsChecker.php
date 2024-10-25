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
            'apache' => 'checkApacheModules',
        ];

        foreach ($allRequirements as $type => $requirements) {
            if ($method = $mapMethod[$type] ?? null) {
                $results['requirements'][$type]
                    = $this->{$method}($requirements);
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

    public function checkApacheModules(array $requirements): array
    {
        $results = [];
        foreach ($requirements as $requirement) {
            $results[$requirement] = function_exists('apache_get_modules')
                && in_array($requirement, apache_get_modules());
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
        $supported = version_compare($currentPhpVersion['version'],
            $minVersionPhp) >= 0;

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
     *
     * @return string minPhpVersion
     */
    protected function getMinPhpVersion(): string
    {
        return $this->minPhpVersion;
    }
}
