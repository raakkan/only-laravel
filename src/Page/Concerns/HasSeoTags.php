<?php

namespace Raakkan\OnlyLaravel\Page\Concerns;

use Illuminate\Support\Facades\Route;
use Raakkan\OnlyLaravel\Facades\PageManager;

trait HasSeoTags
{
    // Add this property to your class to define default robots behavior
    protected $defaultRobotsDirectives = [
        'index' => true,
        'follow' => true,
        'noarchive' => false,
        'nosnippet' => false,
        'max-snippet' => -1,
        'max-image-preview' => 'large',
        'max-video-preview' => -1,
    ];

    public function getSeoTags()
    {
        $page = PageManager::getPageByName($this->name);
        $seoTags = '';

        // Get all active languages
        $languages = \Raakkan\OnlyLaravel\Translation\Models\Language::getActiveLanguages();

        // Add hreflang tags for all active languages
        // foreach ($languages as $language) {
        //     if ($page) {
        //         if ($language->locale == \Raakkan\OnlyLaravel\Translation\Models\Language::getDefaultLocale()) {
        //             $translatedUrl = $page->generateUrl($this->slug);
        //         } else {
        //             $translatedUrl = $page->generateUrl($this->slug, $language->locale);
        //         }
        //     } else {
        //         $translatedUrl = Route::localizedUrl($language->locale);
        //     }
        //     $seoTags .= '<link rel="alternate" hreflang="' . e($language->locale) . '" href="' . e($translatedUrl) . '">';
        // }

        // // Add x-default hreflang
        // if ($page) {
        //     $defaultUrl = $page->generateUrl($this->slug, config('app.fallback_locale'));
        // } else {
        //     $defaultUrl = url('/');
        // }
        // $seoTags .= '<link rel="alternate" hreflang="x-default" href="' . e($defaultUrl) . '">';

        // Escape and fallback for title
        $title = e($this->title ?? $this->seo_title ?? env('APP_NAME', 'Laravel'));
        $separator = e(setting('general.title_separator', '-'));
        $appName = e(env('APP_NAME', 'Laravel'));
        $seoTags .= "<title>{$title} {$separator} {$appName}</title>";

        // Favicon with multiple formats support
        if ($favicon = setting('general.favicon')) {
            $seoTags .= '<link rel="icon" type="image/x-icon" href="'.e($favicon).'">';
            $seoTags .= '<link rel="apple-touch-icon" href="'.e($favicon).'">';
        }

        // Meta description and keywords with escaping
        if ($this->seo_description) {
            $seoTags .= '<meta name="description" content="'.e($this->seo_description).'">';
        }
        if ($this->seo_keywords) {
            $seoTags .= '<meta name="keywords" content="'.e($this->seo_keywords).'">';
        }

        // Add robots meta if specified
        if (isset($this->seo_robots)) {
            $seoTags .= '<meta name="robots" content="'.e($this->seo_robots).'">';
        }

        if ($this->featured_image) {
            $seoTags .= '<meta property="og:image" content="'.$this->featured_image.'">';
        }

        if ($page) {
            $slugUrl = $page->generateUrl($this->slug);
        } else {
            $slugUrl = url($this->slug);
        }

        $seoTags .= '<link rel="canonical" href="'.$slugUrl.'">';
        // $seoTags .= '<meta property="og:locale" content="' . str_replace('_', '-', app()->getLocale()) . '">';
        // foreach ($languages as $language) {
        //     if ($language->locale !== app()->getLocale()) {
        //         $seoTags .= '<meta property="og:locale:alternate" content="' . str_replace('_', '-', $language->locale) . '">';
        //     }
        // }

        if ($page) {
            $jsonLd = $page->generateJsonLd($this, $page);
            if ($jsonLd) {
                $seoTags .= $jsonLd->toScriptTag();
            }
        }

        foreach ($this->generateOpenGraphTags($slugUrl) as $tag => $content) {
            $seoTags .= '<meta property="'.$tag.'" content="'.$content.'">';
        }

        foreach ($this->generateTwitterTags($slugUrl) as $tag => $content) {
            $seoTags .= '<meta name="'.$tag.'" content="'.$content.'">';
        }

        // Add robots meta tag
        $seoTags .= '<meta name="robots" content="'.e($this->generateRobotsTag()).'">';

        return $seoTags;
    }

    private function generateOpenGraphTags($slugUrl)
    {
        $openGraph = [
            'og:title' => e($this->seo_title ?? $this->title ?? env('APP_NAME', 'Laravel')),
            'og:description' => e($this->seo_description ?? ''),
            'og:url' => e($slugUrl),
            'og:type' => 'website',
            'og:locale' => app()->getLocale(),
            'og:site_name' => e(env('APP_NAME', 'Laravel')),
        ];

        if ($this->featured_image) {
            $openGraph['og:image'] = e($this->featured_image);
        }

        return $openGraph;
    }

    private function generateTwitterTags($slugUrl)
    {
        $twitter = [
            'twitter:card' => 'summary_large_image',
            'twitter:title' => e($this->seo_title ?? $this->title ?? env('APP_NAME', 'Laravel')),
            'twitter:description' => e($this->seo_description ?? ''),
            'twitter:url' => e($slugUrl),
            'twitter:site' => e(setting('social.twitter_handle', '')),
            'twitter:creator' => e(setting('social.twitter_handle', '')),
        ];

        if ($this->featured_image) {
            $twitter['twitter:image'] = e($this->featured_image);
            $twitter['twitter:image:alt'] = e($this->featured_image_alt ?? $this->title ?? '');
        }

        return $twitter;
    }

    private function generateRobotsTag()
    {
        // If custom robots tag is set, use it directly
        if (! empty($this->seo_robots)) {
            return $this->seo_robots;
        }

        $directives = [];

        // Basic indexing directives
        $directives[] = $this->defaultRobotsDirectives['index'] ? 'index' : 'noindex';
        $directives[] = $this->defaultRobotsDirectives['follow'] ? 'follow' : 'nofollow';

        // Archive control
        if ($this->defaultRobotsDirectives['noarchive']) {
            $directives[] = 'noarchive';
        }

        // Snippet control
        if ($this->defaultRobotsDirectives['nosnippet']) {
            $directives[] = 'nosnippet';
        }

        // Max snippet length
        if ($this->defaultRobotsDirectives['max-snippet'] >= 0) {
            $directives[] = "max-snippet:{$this->defaultRobotsDirectives['max-snippet']}";
        }

        // Image preview size
        if ($this->defaultRobotsDirectives['max-image-preview'] !== '') {
            $directives[] = "max-image-preview:{$this->defaultRobotsDirectives['max-image-preview']}";
        }

        // Video preview length
        if ($this->defaultRobotsDirectives['max-video-preview'] >= 0) {
            $directives[] = "max-video-preview:{$this->defaultRobotsDirectives['max-video-preview']}";
        }

        return implode(', ', $directives);
    }
}
