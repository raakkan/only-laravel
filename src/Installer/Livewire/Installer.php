<?php

namespace Raakkan\OnlyLaravel\Installer\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Raakkan\OnlyLaravel\Theme\ThemeManager;
use Raakkan\OnlyLaravel\Facades\MenuManager;
use Raakkan\OnlyLaravel\Facades\OnlyLaravel;
use Raakkan\OnlyLaravel\Facades\PageManager;
use Raakkan\OnlyLaravel\Plugin\PluginManager;
use Raakkan\OnlyLaravel\Facades\TemplateManager;
use Raakkan\OnlyLaravel\Installer\Steps\DatabaseStep;
use Raakkan\OnlyLaravel\Installer\Steps\WebsiteInfoStep;
use Raakkan\OnlyLaravel\Installer\Steps\AdminAccountStep;

class Installer extends Component
{
    public $currentStep = 'requirements';

    public $inputs = [];

    public function mount()
    {
        if ($step = request()->segment(2)) {
            if (array_key_exists($step, $this->getSteps())) {
                $this->currentStep = $step;
            }
        }

        $cssBuilder = \Raakkan\OnlyLaravel\Template\CssBuilder::make([
            __DIR__.'/../../../resources/views/installer/components/layouts/app.blade.php',
            __DIR__.'/../../../resources/views/installer/livewire/installer.blade.php',
            __DIR__.'/../../../resources/views/installer/steps/requirements.blade.php',
            __DIR__.'/../../../resources/views/installer/steps/folder-permissions.blade.php',
            __DIR__.'/../../../resources/views/installer/steps/database.blade.php',
            __DIR__.'/../../../resources/views/installer/steps/admin-account.blade.php',
            __DIR__.'/../../../resources/views/installer/steps/plugins.blade.php',
            __DIR__.'/../../../resources/views/installer/steps/themes.blade.php',
            __DIR__.'/../../../resources/views/installer/steps/website-info.blade.php',
        ]);
        $cssBuilder->setFileName('installer');
        $cssBuilder->setFolderName('installer');
        $cssBuilder->saveCssToFile();

        // if (file_exists(storage_path('onlylaravel/installed'))) {
        //     return redirect()->to('/');
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
            $this->updateUrl();
        }
    }

    public function nextStep()
    {
        $installManager = app('install-manager');
        $steps = $installManager->getSteps();
        $currentStep = $installManager->getStep($this->currentStep);

        Log::info('Moving to next step', [
            'current_step' => $this->currentStep,
            'inputs' => $this->inputs
        ]);

        if ($currentStep instanceof DatabaseStep || $currentStep instanceof AdminAccountStep || $currentStep instanceof WebsiteInfoStep) {
            $currentStep->setInputs($this->inputs);
        }

        if ($currentStep) {
            $isValid = $currentStep->validate();
            Log::info('Step validation result:', ['valid' => $isValid]);

            if ($isValid) {
                $keys = array_keys($steps);
                $currentIndex = array_search($this->currentStep, $keys);

                if ($currentIndex !== false && $currentIndex < count($keys) - 1) {
                    $this->currentStep = $keys[$currentIndex + 1];
                    $this->updateUrl();
                    $currentStep = $installManager->getStep($this->currentStep);
                    if ($currentStep instanceof DatabaseStep || $currentStep instanceof AdminAccountStep || $currentStep instanceof WebsiteInfoStep) {
                        $this->inputs = $currentStep->getInputs();
                    }
                    return;
                }
            } else {
                $this->addError('step', $currentStep->getErrorMessage() ?: 'Validation failed. Please check your inputs.');
            }
        }
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
        // Extend PHP execution time for installation process
        set_time_limit(300); // 5 minutes
        ini_set('max_execution_time', 300);

        $installManager = app('install-manager');
        $currentStep = $installManager->getStep($this->currentStep);
        $currentStep->setInputs($this->inputs);

        $isValid = $currentStep->validate();

        if ($isValid) {
            try {
                OnlyLaravel::install();
                file_put_contents(storage_path('installed'), 'Installation completed on '.date('Y-m-d H:i:s'));

                return redirect()->to('/');
            } catch (\Exception $e) {
                Log::error('Installation failed: '.$e->getMessage());
                $this->addError('step', 'Installation failed: '.$e->getMessage());
            }
        } else {
            $this->addError('step', $currentStep->getErrorMessage() ?: 'Validation failed. Please check your inputs.');
        }
    }

    public function activatePlugin(string $name)
    {
        try {
            app(PluginManager::class)->activatePlugin($name);
            \Artisan::call('cache:clear');
            \Artisan::call('config:clear');
        } catch (\Exception $e) {
            $this->addError('plugin', 'Failed to activate plugin: ' . $e->getMessage());
        }
    }

    public function deactivatePlugin(string $name)
    {
        try {
            app(PluginManager::class)->deactivatePlugin($name);
            \Artisan::call('cache:clear');
            \Artisan::call('config:clear');
        } catch (\Exception $e) {
            $this->addError('plugin', 'Failed to deactivate plugin: ' . $e->getMessage());
        }
    }

    public function activateTheme(string $name)
    {
        try {
            $themeManager = app(ThemeManager::class);
            if ($themeManager->activateTheme($name)) {
                \Artisan::call('view:clear');
                \Artisan::call('cache:clear');
                \Artisan::call('config:clear');

                // Clear template CSS files
                $templatesPath = public_path('css/templates');
                if (File::exists($templatesPath)) {
                    File::deleteDirectory($templatesPath);
                }

                // Build CSS for all pages
                try {
                    $pages = \Raakkan\OnlyLaravel\Models\PageModel::all();
                    foreach ($pages as $page) {
                        $pageTemplate = $page->getPageTemplate();
                        $pageTemplate->buildCss();
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to build CSS: ' . $e->getMessage());
                }
            }
        } catch (\Exception $e) {
            $this->addError('theme', 'Failed to activate theme: ' . $e->getMessage());
        }
    }

    public function updateTheme(string $name)
    {
        try {
            $themeManager = app(ThemeManager::class);
            if ($themeManager->updateTheme($name)) {
                \Artisan::call('view:clear');
                \Artisan::call('cache:clear');
                \Artisan::call('config:clear');

                $templatesPath = public_path('css/templates');
                if (File::exists($templatesPath)) {
                    File::deleteDirectory($templatesPath);
                }
            }
        } catch (\Exception $e) {
            $this->addError('theme', 'Failed to update theme: ' . $e->getMessage());
        }
    }

    protected function updateUrl()
    {
        $url = url("/install/{$this->currentStep}");
        $this->dispatch('urlChanged', ['url' => $url]);
    }
}
