<?php

namespace Raakkan\OnlyLaravel\OnlyLaravel\Concerns;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait CollectsSettingPages
{
    public function collectAndStoreSettingPages()
    {
        $settingPages = $this->getSettingPages();

        foreach ($settingPages as $settingPage) {
            $this->storeDefaultValues($settingPage);
        }
    }

    protected function getSettingPages()
    {
        $settingPagesPath = app_path('OnlyLaravel/Settings');
        $namespace = 'App\\OnlyLaravel\\Settings\\';

        return collect(File::allFiles($settingPagesPath))
            ->map(function ($file) use ($namespace) {
                $fileName = $file->getRelativePathname();
                $className = $namespace.Str::replaceLast('.php', '', $fileName);

                return new $className;
            })
            ->filter(function ($class) {
                return method_exists($class, 'schema');
            });
    }

    protected function storeDefaultValues($settingPage)
    {
        $schema = $settingPage->schema();
        $this->processSchema($schema);
    }

    protected function processSchema($schema)
    {
        foreach ($schema as $component) {
            if ($component instanceof Field && $this->hasFieldDefaultValue($component)) {
                $this->storeFieldDefaultValue($component);
            }

            if ($component instanceof Component && $component->hasChildComponentContainer(true)) {
                $this->processSchema($component->getChildComponents());
            }
        }
    }

    protected function hasFieldDefaultValue($field)
    {
        try {
            return $field->getDefaultState() !== null;
        } catch (\Throwable $th) {
            return false;
        }
    }

    protected function storeFieldDefaultValue($field)
    {
        $key = $field->getName();
        $defaultValue = $field->getDefaultState();

        // Check if the setting already exists
        $existingSetting = DB::table('settings')->where('key', $key)->first();

        if (! $existingSetting) {
            // Prepare the value for JSON storage
            $value = $this->prepareValueForStorage($defaultValue);

            // If the setting doesn't exist, insert it
            DB::table('settings')->insert([
                'key' => $key,
                'value' => $value,
            ]);
        }
    }

    protected function prepareValueForStorage($value)
    {
        if (is_bool($value)) {
            return json_encode($value);
        } elseif (is_null($value)) {
            return json_encode(null);
        } elseif (is_array($value) || is_object($value)) {
            return json_encode($value);
        } elseif (is_string($value) || is_numeric($value)) {
            return json_encode($value);
        } else {
            // For any other types, convert to string and then JSON encode
            return json_encode((string) $value);
        }
    }
}
