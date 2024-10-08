<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Components;

use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Raakkan\OnlyLaravel\Template\Concerns\Design\HasBackgroundSettings;

class FooterBlockComponent extends BlockComponent
{
    protected string $name = 'footer-component';
    protected $group = 'core';
    protected $source = 'raakkan/only-laravel';
    protected $view = 'only-laravel::template.components.footer';
    protected $copyrightText;
    protected $additionalText;
    protected $showSocialIcons;
    protected $socialLinks;
    protected $customLinks;

    public function __construct()
    {
        $this->enableCustomStyleSettingOnly(['customStyleSettings', 'customCssSettings']);
    }

    public function getBlockSettings()
    {
        return [
            TextInput::make('footer.copyright_text')
                ->label('Copyright Text')
                ->default($this->getCopyrightText())
                ->required(),
            Textarea::make('footer.additional_text')
                ->label('Additional Text')
                ->default($this->getAdditionalText())
                ->rows(3),
            Toggle::make('footer.show_social_icons')
                ->label('Show Social Icons')
                ->default($this->getShowSocialIcons()),
            TextInput::make('footer.facebook_link')
                ->label('Facebook Link')
                ->default($this->getSocialLinks()['facebook'] ?? '')
                ->url()
                ->visible(fn ($get) => $get('footer.show_social_icons')),
            TextInput::make('footer.instagram_link')
                ->label('Instagram Link')
                ->default($this->getSocialLinks()['instagram'] ?? '')
                ->url()
                ->visible(fn ($get) => $get('footer.show_social_icons')),
            TextInput::make('footer.twitter_link')
                ->label('Twitter Link')
                ->default($this->getSocialLinks()['twitter'] ?? '')
                ->url()
                ->visible(fn ($get) => $get('footer.show_social_icons')),
            Repeater::make('footer.custom_links')
                ->label('Custom Links')
                ->schema([
                    TextInput::make('name')
                        ->label('Name')
                        ->required(),
                    TextInput::make('url')
                        ->label('URL')
                        ->url()
                        ->required(),
                    Textarea::make('icon')
                        ->label('Icon (Full SVG)')
                        ->required()
                        ->helperText('Enter the full SVG code for the icon')
                        ->helperText('For best results, submit SVG without color. The icon color will be set automatically.'),
                ])
                ->visible(fn ($get) => $get('footer.show_social_icons'))
                ->collapsible(),
        ];
    }

    public function setBlockSettings($settings)
    {
        if (is_array($settings) && array_key_exists('footer', $settings)) {
            $footer = $settings['footer'];

            $this->copyrightText = $footer['copyright_text'] ?? '';
            $this->additionalText = $footer['additional_text'] ?? '';
            $this->showSocialIcons = $footer['show_social_icons'] ?? true;

            $this->socialLinks = [
                'facebook' => $footer['facebook_link'] ?? '',
                'instagram' => $footer['instagram_link'] ?? '',
                'twitter' => $footer['twitter_link'] ?? '',
            ];

            $this->customLinks = $footer['custom_links'] ?? [];
        }

        return $this;
    }

    public function getCopyrightText()
    {
        return $this->copyrightText;
    }

    public function getAdditionalText()
    {
        return $this->additionalText;
    }

    public function getShowSocialIcons()
    {
        return $this->showSocialIcons;
    }

    public function getSocialLinks()
    {
        return $this->socialLinks;
    }

    public function getCustomLinks()
    {
        return $this->customLinks;
    }

    public function copyrightText($text)
    {
        $this->copyrightText = $text;
        return $this;
    }

    public function additionalText($text)
    {
        $this->additionalText = $text;
        return $this;
    }

    public function showSocialIcons($show = true)
    {
        $this->showSocialIcons = $show;
        return $this;
    }

    public function socialLink($social, $url)
    {
        $this->socialLinks[$social] = $url;
        return $this;
    }

    public function socialLinks($links)
    {
        $this->socialLinks = $links;
        return $this;
    }

    public function customLink($name, $url, $icon)
    {
        $this->customLinks[] = [
            'name' => $name,
            'url' => $url,
            'icon' => $icon,
        ];
        return $this;
    }

    public function customLinks($links)
    {
        $this->customLinks = $links;
        return $this;
    }

    public function getViewPaths()
    {
        return [
            resource_path('views/vendor/only-laravel/template/components/footer.blade.php'),
            __DIR__ . '/../../../../resources/views/template/components/footer.blade.php',
        ];
    }
}