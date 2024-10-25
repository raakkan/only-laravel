<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Components;

use Illuminate\Support\Facades\Storage;

class ImageBlockComponent extends BlockComponent
{
    protected string $name = 'image';

    protected $group = 'core';

    protected $source = 'raakkan/only-laravel';

    protected $view = 'only-laravel::template.components.image';

    protected $image;

    protected $altText;

    protected $imagePosition;

    public function __construct()
    {
        $this->enableCustomStyleSettingOnly(['customStyleSettings', 'customCssSettings']);
    }

    public function getBlockSettings()
    {
        return [
            // FileUpload::make('image.file')
            //     ->label('Image')
            //     ->image()
            //     ->required(),
            // TextInput::make('image.alt_text')
            //     ->label('Alt Text')
            //     ->required(),
            // Select::make('image.position')
            //     ->label('Image Position')
            //     ->options([
            //         'left' => 'Left',
            //         'center' => 'Center',
            //         'right' => 'Right',
            //     ])
            //     ->default('center'),
        ];
    }

    public function setBlockSettings($settings)
    {
        if (is_array($settings) && array_key_exists('image', $settings)) {
            $image = $settings['image'];

            $this->image = $image['file'] ?? null;
            $this->altText = $image['alt_text'] ?? '';
            $this->imagePosition = $image['position'] ?? 'center';
        }

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getImageUrl()
    {
        return Storage::url($this->image);
    }

    public function getAltText()
    {
        return $this->altText;
    }

    public function getImagePosition()
    {
        return $this->imagePosition;
    }

    public function getViewPaths()
    {
        return [
            resource_path('views/vendor/only-laravel/template/components/image.blade.php'),
            __DIR__.'/../../../../resources/views/template/components/image.blade.php',
        ];
    }
}
