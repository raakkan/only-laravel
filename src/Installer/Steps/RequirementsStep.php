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
        $step = new self();
        $step->init();
        return $step;
    }

    public function init()
    {
        $requirements = [
            'php'    => [
                'openssl',
                'pdo',
                'mbstring',
                'tokenizer',
                'JSON',
                'cURL',
            ],
            'apache' => [
                'mod_rewrite',
            ],
        ];
        $minPhpVersion = '8.1.0';

        $results = RequirementsChecker::make($requirements, $minPhpVersion);

        $this->requirements = $results;
        $this->phpVersion = $results['phpVersion'];
    }

    public function validate(): bool
    {
        $allRequirementsMet = true;
        $errors = [];

        // Check PHP extensions and Apache modules
        foreach ($this->requirements['requirements'] as $type => $requirements) {
            foreach ($requirements as $requirement => $met) {
                if (!$met) {
                    $allRequirementsMet = false;
                    $errors[] = "The {$requirement} {$type} requirement is not met.";
                }
            }
        }

        // Check PHP version
        $phpVersionSupported = $this->requirements['phpVersion']['supported'];
        if (!$phpVersionSupported) {
            $allRequirementsMet = false;
            $errors[] = "The PHP version requirement is not met.";
        }

        if (!$allRequirementsMet) {
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