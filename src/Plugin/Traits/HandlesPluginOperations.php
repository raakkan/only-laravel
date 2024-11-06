<?php

namespace Raakkan\OnlyLaravel\Plugin\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Livewire\Mechanisms\ComponentRegistry;
use Raakkan\OnlyLaravel\Plugin\Models\PluginModel;
use Raakkan\OnlyLaravel\Translation\TranslationLoader;

//TODO: Add plugin deletion and uninstallation
trait HandlesPluginOperations
{
    protected $loadedFiles = [];

    protected function bootPlugin(PluginModel $plugin): void
    {
        if($this->isPluginClassExists($plugin->name)) {
            $this->autoload($plugin->name);
            $pluginClass = $this->getPluginClass($plugin->name);

            $menus = $pluginClass->getMenus();
            $templates = $pluginClass->getTemplates();
            $pages = $pluginClass->getPages();

            app('menu-manager')->registerMenus($menus);
            app('template-manager')->registerTemplates($templates);
            app('page-manager')->registerPages($pages);

            $pluginClass->boot($this);
            $pluginClass->onlyLaravel(app('only-laravel'));
            $pluginClass->pages(app('page-manager'));
            $pluginClass->menus(app('menu-manager'));
            $pluginClass->templates(app('template-manager'));
        }

        $pluginPath = $this->getPluginPath($plugin->name);

        if(File::exists($pluginPath.'/routes/web.php')) {
            $this->loadRoutes($pluginPath.'/routes/web.php', 'web');
        }

        if(File::exists($pluginPath.'/routes/api.php')) {
            $this->loadRoutes($pluginPath.'/routes/api.php', 'api');
        }

        if(File::exists($pluginPath.'/resources/views/components')) {
            Blade::anonymousComponentNamespace($pluginPath.'/resources/views/components', $plugin->name);
        }

        if(File::exists($pluginPath.'/resources/views')) {
            app('view')->addNamespace($plugin->name, $pluginPath.'/resources/views');
        }

        if(File::exists($pluginPath.'/src/Livewire')) {
            $pluginJson = $this->getPluginJson($plugin->name);
            $this->registerLivewireComponents($pluginPath.'/src/Livewire', $plugin->name, $pluginJson->getNamespace().'\Livewire');
        }

        if(File::exists($pluginPath.'/lang')) {
            app('translator')->addNamespace($plugin->name, $pluginPath.'/lang');
        }
    }

    protected function loadRoutes($path, $middleware = 'web')
    {
        if (file_exists($path) && $middleware === 'web') {
            Route::middleware($middleware)->group(function () use ($path) {
                include $path;
            });
        }

        if (file_exists($path) && $middleware === 'api') {
            Route::middleware($middleware)->prefix('api')->group(function () use ($path) {
                include $path;
            });
        }
    }

    public function registerLivewireComponents($path, $name, $namespace)
    {
        if (is_dir($path)) {
            foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path)) as $file) {
                if ($file->isFile() && $file->getExtension() === 'php') {
                    $className = $namespace.'\\'.str_replace('/', '\\', substr($file->getPathname(), strlen($path) + 1, -4));
                    
                    if (is_subclass_of($className, \Livewire\Component::class)) {
                        $componentName = (new \ReflectionClass($className))->getShortName();
                        
                        // Check if it's a full-page component
                        if (method_exists($className, 'isFullPage') && $className::isFullPage()) {
                            $routeName = $className::getRouteName() ?? Str::kebab($componentName);
                            $routePath = $className::getRoutePath() ?? $routeName;
                            
                            // Register both as route and Livewire component
                            Route::get($routePath, $className)
                                ->name($routeName)
                                ->middleware(array_merge(['web'], $className::getMiddleware()));
                            $componentRegistry = app(ComponentRegistry::class);
                            \Livewire\Livewire::component($componentRegistry->getName($className), $className);
                        } else {
                            // Register as regular component
                            \Livewire\Livewire::component($name.'::'.$className::getComponentName(), $className);
                        }
                    }
                }
            }
        }
    }

    protected function registerPlugin(PluginModel $plugin): void
    {
        if ($this->isPluginClassExists($plugin->name)) {
            $this->autoload($plugin->name);
            $this->loadMigrations($plugin->name);
            if ($this->checkRequirements($plugin->name)) {
                $pluginClass = $this->getPluginClass($plugin->name);
                
                $menus = $pluginClass->getMenus();
                $templates = $pluginClass->getTemplates();
                $pages = $pluginClass->getPages();

                foreach ($menus as $menu) {
                    $menu->create();
                }
                foreach ($templates as $template) {
                    $template->create();
                }
                foreach ($pages as $page) {
                    $page->create();
                }
            } else {
                $this->updateRequirementsStatus($plugin, ['passed' => false]);
                $this->rollbackMigrations($plugin->name);
                $plugin->update(['is_active' => false]);
                cache()->forget('active_plugins');
                $this->unload($plugin->name);
                \Log::error("Plugin requirements not met for {$plugin->name}");
                throw new \Exception("Plugin requirements not met for {$plugin->name}");
            }
        }

        $langPath = 'plugins/'.basename($this->getPluginPath($plugin->name)).'/lang';
        TranslationLoader::loadAndSave($langPath);
    }

    protected function getPluginClass(string $name)
    {
        $path = $this->getPluginPath($name);
        $pluginFile = $path.'/src/Plugin.php';

        if (! File::exists($pluginFile)) {
            return;
        }

        $namespace = $this->getPluginJson($name)->getNamespace();
        $pluginClass = $namespace.'\Plugin';

        return new $pluginClass;
    }

    protected function isPluginClassExists(string $name): bool
    {
        $path = $this->getPluginPath($name);
        $pluginFile = $path.'/src/Plugin.php';

        return File::exists($pluginFile);
    }

    public function autoload(string $name): void
    {
        $path = $this->getPluginPath($name).'/src';

        if (File::isDirectory($path)) {
            $files = File::allFiles($path);

            foreach ($files as $file) {
                if (Str::endsWith($file->getFilename(), '.php')) {
                    $filepath = $file->getPathname();
                    
                    // Skip if already loaded
                    if (in_array($filepath, $this->loadedFiles)) {
                        continue;
                    }

                    include_once $filepath;
                    $this->loadedFiles[] = $filepath;
                }
            }
        }
    }

    public function unload(string $name): void
    {
        $path = realpath($this->getPluginPath($name).'/src');
        
        // Filter loaded files for this specific plugin
        $pluginFiles = array_filter($this->loadedFiles, function($file) use ($path) {
            $realFile = realpath($file);
            return $realFile && Str::startsWith($realFile, $path);
        });

        foreach ($pluginFiles as $file) {
            
            // Optionally clear opcache for these files
            if (function_exists('opcache_invalidate')) {
                opcache_invalidate($file, true);
            }
            
            // Remove from loaded files tracking
            $this->loadedFiles = array_diff($this->loadedFiles, [$file]);
        }
    }

    protected function loadMigrations(string $name): void
    {
        $pluginPath = $this->getPluginPath($name);
        $migrationPath = $pluginPath . '/database/migrations';
        
        if (File::exists($migrationPath)) {
            try {
                $migrator = app('migrator');
                Artisan::call('optimize:clear');
                
                $migrationFiles = File::glob($migrationPath . '/*_*.php');
                
                foreach ($migrationFiles as $file) {
                    $migrationName = str_replace('.php', '', basename($file));
                    
                    if (!$migrator->repositoryExists()) {
                        $migrator->getRepository()->createRepository();
                    }
                    
                    $ranMigrations = collect($migrator->getRepository()->getRan());
                    
                    if (!$ranMigrations->contains($migrationName)) {
                        $migrator->run([$file]);
                        \Log::info("Ran migration: " . $migrationName . " for plugin: " . $name);
                    }
                }
                
                Artisan::call('optimize:clear');
                
            } catch (\Exception $e) {
                \Log::error("Failed to run migrations for plugin {$name}: " . $e->getMessage());
                \Log::error($e->getTraceAsString());
            }
        }
    }

    protected function checkRequirements(string $name): bool
    {
        try {
            $requirementsPath = $this->getPluginPath($name) . '/requirements.json';
            $plugin = PluginModel::where('name', $name)->first();
            $status = [
                'has_requirements_file' => false,
                'checks' => [],
                'passed' => true
            ];
            
            if (!File::exists($requirementsPath)) {
                \Log::info("No requirements file found for plugin: {$name}");
                $this->updateRequirementsStatus($plugin, $status);
                return true;
            }

            \Log::info("Checking requirements for plugin: {$name}");
            $status['has_requirements_file'] = true;
            $requirements = json_decode(File::get($requirementsPath), true);

            // Check PHP version
            if (isset($requirements['php_version'])) {
                $phpVersion = trim($requirements['php_version'], '>=');
                $passed = version_compare(PHP_VERSION, $phpVersion, '>=');
                $status['checks']['php_version'] = [
                    'required' => $phpVersion,
                    'current' => PHP_VERSION,
                    'passed' => $passed
                ];
                
                \Log::info("PHP version check for {$name}", [
                    'required' => $phpVersion,
                    'current' => PHP_VERSION,
                    'passed' => $passed
                ]);
                
                if (!$passed) {
                    $status['passed'] = false;
                    \Log::error("PHP version check failed for {$name}");
                    return false;
                }
            }
            
            // Check Laravel version
            if (isset($requirements['laravel_version'])) {
                $laravelVersion = trim($requirements['laravel_version'], '>=');
                $passed = version_compare(app()->version(), $laravelVersion, '>=');
                $status['checks']['laravel_version'] = [
                    'required' => $laravelVersion,
                    'current' => app()->version(),
                    'passed' => $passed
                ];
                
                \Log::info("Laravel version check for {$name}", [
                    'required' => $laravelVersion,
                    'current' => app()->version(),
                    'passed' => $passed
                ]);
                
                if (!$passed) {
                    $status['passed'] = false;
                    \Log::error("Laravel version check failed for {$name}");
                    return false;
                }
            }
            
            // Check database tables
            if (isset($requirements['database']['tables'])) {
                $tableChecks = [];
                foreach ($requirements['database']['tables'] as $table) {
                    $exists = Schema::hasTable($table);
                    $tableChecks[$table] = $exists;
                    
                    \Log::info("Database table check for {$name}", [
                        'table' => $table,
                        'exists' => $exists
                    ]);
                    
                    if (!$exists) {
                        $status['passed'] = false;
                        \Log::error("Required table '{$table}' missing for plugin {$name}");
                        return false;
                    }
                }
                $status['checks']['database_tables'] = $tableChecks;
            }

            \Log::info("Requirements check completed for {$name}", [
                'status' => $status
            ]);
            
            $this->updateRequirementsStatus($plugin, $status);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function updateRequirementsStatus(PluginModel $plugin, array $status): void
    {
        $plugin->update([
            'requirements_status' => $status,
            'requirements_checked_at' => now(),
        ]);
    }

    protected function rollbackMigrations(string $name): void
    {
        $pluginPath = $this->getPluginPath($name);
        $migrationPath = $pluginPath . '/database/migrations';
        
        if (File::exists($migrationPath)) {
            try {
                Artisan::call('optimize:clear');
                
                // Get all migration files from the plugin
                $migrationFiles = File::glob($migrationPath . '/*_*.php');
                
                // Get the migrator instance
                $migrator = app('migrator');
                
                // Get list of migrations that have been run
                if (!$migrator->repositoryExists()) {
                    $migrator->getRepository()->createRepository();
                }
                
                $ranMigrations = collect($migrator->getRepository()->getRan())
                    ->filter(function($migration) use ($migrationFiles, $migrationPath) {
                        // Only include migrations that are from this plugin
                        return in_array($migrationPath . '/' . $migration . '.php', $migrationFiles);
                    });

                // Rollback each migration
                foreach ($ranMigrations->reverse() as $migration) {
                    $file = $migrationPath . '/' . $migration . '.php';
                    if (File::exists($file)) {
                        $migrator->rollback([$file]);
                        \Log::info("Rolled back migration: " . $migration . " for plugin: " . $name);
                    }
                }
                
                Artisan::call('optimize:clear');
                
            } catch (\Exception $e) {
                \Log::error("Failed to rollback migrations for plugin {$name}: " . $e->getMessage());
                \Log::error($e->getTraceAsString());
            }
        }
    }
} 