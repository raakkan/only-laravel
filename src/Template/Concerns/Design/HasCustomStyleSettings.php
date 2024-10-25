<?php

namespace Raakkan\OnlyLaravel\Template\Concerns\Design;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Arr;
use Storage;

trait HasCustomStyleSettings
{
    protected $customStyleSettings = false;

    protected $customCssSettings = false;

    protected $customCssFilesSettings = false;

    protected $customJsFilesSettings = false;

    protected $customScript = false;

    protected $coreFileSettings = false;

    protected $includeCoreFiles = false;

    public function getCustomStyle()
    {
        return Arr::get($this->settings, 'onlylaravel.custom_style', '');
    }

    public function getCustomCss()
    {
        return Arr::get($this->settings, 'onlylaravel.custom_css', '');
    }

    public function getCustomCssFiles()
    {
        return Arr::get($this->settings, 'onlylaravel.custom_css_files', []);
    }

    public function getCustomJsFiles()
    {
        return Arr::get($this->settings, 'onlylaravel.custom_js_files', []);
    }

    public function getCustomScript()
    {
        return Arr::get($this->settings, 'onlylaravel.custom_script');
    }

    public function getIncludeCoreFiles()
    {
        return Arr::get($this->settings, 'onlylaravel.include_core_files', true);
    }

    public function getCustomStyleSettingFields()
    {
        $fields = [];

        if ($this->customStyleSettings) {
            $fields[] = Textarea::make('onlylaravel.custom_style')->label('Custom Style')->rows(4)->default($this->getCustomStyle());
        }

        if ($this->customCssSettings) {
            $fields[] = Textarea::make('onlylaravel.custom_css')->label('Custom CSS')->rows(4)->default($this->getCustomCss());
        }

        if ($this->customCssFilesSettings) {
            $fields[] = FileUpload::make('onlylaravel.custom_css_files')
                ->label('Custom CSS Files')
                ->directory('assets/css')
                ->multiple()
                ->storeFileNamesIn('attachment_file_names')
                ->acceptedFileTypes(['text/css'])->default($this->getCustomCssFiles());
        }

        if ($this->customJsFilesSettings) {
            $fields[] = FileUpload::make('onlylaravel.custom_js_files')
                ->label('Custom JS Files')
                ->directory('assets/js')
                ->multiple()
                ->storeFileNamesIn('attachment_file_names')
                ->acceptedFileTypes(['application/javascript'])->default($this->getCustomJsFiles());
        }

        if ($this->customScript) {
            $fields[] = Textarea::make('onlylaravel.custom_script')->label('Custom Script')->rows(4)->default($this->getCustomScript());
        }

        if ($this->coreFileSettings) {
            $fields[] = Toggle::make('onlylaravel.include_core_files')->label('Include Core Files')->default($this->includeCoreFiles);
        }

        return $fields;
    }

    public function hasCustomStyleSettingsEnabled()
    {
        return $this->customStyleSettings || $this->customCssSettings || $this->customCssFilesSettings || $this->customJsFilesSettings || $this->customScript || $this->coreFileSettings;
    }

    public function customStyle($style = '')
    {
        $this->customStyleSettings = true;
        Arr::set($this->settings, 'onlylaravel.custom_style', $style);

        return $this;
    }

    public function customCss($css = '')
    {
        $this->customCssSettings = true;
        Arr::set($this->settings, 'onlylaravel.custom_css', $css);

        return $this;
    }

    public function customCssFiles($files = [])
    {
        $this->customCssFilesSettings = true;
        Arr::set($this->settings, 'onlylaravel.custom_css_files', $files);

        return $this;
    }

    public function customJsFiles($files = [])
    {
        $this->customJsFilesSettings = true;
        Arr::set($this->settings, 'onlylaravel.custom_js_files', $files);

        return $this;
    }

    public function customScript($script = '')
    {
        $this->customScript = true;
        Arr::set($this->settings, 'onlylaravel.custom_script', $script);

        return $this;
    }

    public function coreFileSettings($value = true)
    {
        $this->coreFileSettings = true;
        Arr::set($this->settings, 'onlylaravel.include_core_files', $value);

        return $this;
    }

    public function getCustomFilesWithTags()
    {
        $cssFiles = $this->getCustomCssFiles();
        $jsFiles = $this->getCustomJsFiles();
        $tags = [];

        foreach ($cssFiles as $file) {
            $cssUrl = Storage::url($file);
            $tags[] = '<link rel="stylesheet" href="'.$cssUrl.'">';
        }

        foreach ($jsFiles as $file) {
            $jsUrl = Storage::url($file);
            $tags[] = '<script src="'.$jsUrl.'"></script>';
        }

        return implode("\n", $tags);
    }

    public function enableCustomStyleSettingOnly(array|string $setting = 'customStyleSettings')
    {
        $this->customStyleSettings = false;
        $this->customCssSettings = false;
        $this->customCssFilesSettings = false;
        $this->customJsFilesSettings = false;
        $this->customScript = false;
        $this->coreFileSettings = false;

        if (is_array($setting)) {
            foreach ($setting as $s) {
                $this->{$s} = true;
            }

            return $this;
        }

        $this->{$setting} = true;

        return $this;
    }
}
