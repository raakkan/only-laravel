<?php

namespace Raakkan\OnlyLaravel\Installer\Livewire;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Raakkan\OnlyLaravel\Installer\Steps\AdminAccountStep;
use Raakkan\OnlyLaravel\Installer\Steps\DatabaseStep;
use Raakkan\OnlyLaravel\Installer\Steps\WebsiteInfoStep;

class Installer extends Component
{
    public $currentStep = 'website-info';

    public $inputs = [];

    public function mount()
    {
        $cssBuilder = \Raakkan\OnlyLaravel\Template\CssBuilder::make([
            __DIR__.'/../../../resources/views/installer/components/layouts/app.blade.php',
            __DIR__.'/../../../resources/views/installer/livewire/installer.blade.php',
            __DIR__.'/../../../resources/views/installer/steps/requirements.blade.php',
            __DIR__.'/../../../resources/views/installer/steps/folder-permissions.blade.php',
            __DIR__.'/../../../resources/views/installer/steps/database.blade.php',
            __DIR__.'/../../../resources/views/installer/steps/admin-account.blade.php',
            __DIR__.'/../../../resources/views/installer/steps/website-info.blade.php',
        ]);
        $cssBuilder->setFileName('installer');
        $cssBuilder->setFolderName('installer');
        $cssBuilder->saveCssToFile();

        // if (file_exists(storage_path('installed'))) {
        //     // ... existing redirect code ...
        // }
    }

    public function getSteps()
    {
        return app('install-manager')->getSteps();
    }

    public function previousStep()
    {
        $installManager = app('install-manager');
        $steps = $installManager->getSteps();
        $keys = array_keys($steps);
        $currentIndex = array_search($this->currentStep, $keys);

        if ($currentIndex !== false && $currentIndex > 0) {
            $this->currentStep = $keys[$currentIndex - 1];
        }
    }

    public function nextStep()
    {
        $installManager = app('install-manager');
        $steps = $installManager->getSteps();
        $currentStep = $installManager->getStep($this->currentStep);

        if ($currentStep instanceof DatabaseStep || $currentStep instanceof AdminAccountStep || $currentStep instanceof WebsiteInfoStep) {
            $currentStep->setInputs($this->inputs);
        }

        if ($currentStep) {
            if ($currentStep->validate()) {
                $keys = array_keys($steps);
                $currentIndex = array_search($this->currentStep, $keys);

                if ($currentIndex !== false && $currentIndex < count($keys) - 1) {
                    $this->currentStep = $keys[$currentIndex + 1];
                }
            } else {
                $this->addError('step', $currentStep->getErrorMessage() ?: 'Validation failed. Please check your inputs.');
            }
        }
    }

    public function dehydrate(): void
    {
        Log::info('installation dehydrate...');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
    }

    public function render()
    {
        $currentStep = $this->getSteps()[$this->currentStep];
        $title = $currentStep->getTitle();

        return view('only-laravel::installer.livewire.installer')
            ->layout('only-laravel::installer.components.layouts.app', ['title' => $title]);
    }

    public function finishInstallation()
    {
        $installManager = app('install-manager');
        $steps = $installManager->getSteps();

        // Validate all steps
        foreach ($steps as $stepKey => $step) {
            if ($step instanceof DatabaseStep || $step instanceof AdminAccountStep || $step instanceof WebsiteInfoStep) {
                $step->setInputs($this->inputs);
            }

            if (! $step->validate()) {
                $this->addError('step', $step->getErrorMessage() ?: 'Validation failed for '.$step->getTitle().'. Please check your inputs.');
                $this->currentStep = $stepKey;

                return;
            }
        }

        // Perform installation
        try {
            // Mark installation as complete
            file_put_contents(storage_path('installed'), 'Installation completed on '.date('Y-m-d H:i:s'));

            // Redirect to the home page or a success page
            return redirect()->to('/')->with('success', 'Installation completed successfully!');
        } catch (\Exception $e) {
            Log::error('Installation failed: '.$e->getMessage());
            $this->addError('step', 'Installation failed: '.$e->getMessage());
        }
    }
}
