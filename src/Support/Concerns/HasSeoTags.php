<?php

namespace Raakkan\OnlyLaravel\Support\Concerns;
use Raakkan\OnlyLaravel\Facades\PageManager;

trait HasSeoTags
{
    public function getSeoTags()
    {
        $pageType = PageManager::findPageTypeByType($this->pageType);
        
        $seoTags = '';

        $title = isset($this->seo_title) && $this->seo_title != '' ? $this->seo_title : $this->title;
        $seoTags .= '<title>' . $title . ' ' . setting('general.title_separator', '-') . ' ' . setting('general.site_name', 'Tools') . '</title>';
        $seoTags .= '<meta name="description" content="' . $this->seo_description . '">';
        $seoTags .= '<meta name="keywords" content="' . $this->seo_keywords . '">';
        
        if ($this->getFeaturedImageUrl()) {
            $seoTags .= '<meta property="og:image" content="' . $this->getFeaturedImageUrl() . '">';
        }

        $slugUrl = $this->name == 'home-page' ? url('/') : $pageType->generateUrl($this->slug);
        
        $seoTags .= '<link rel="canonical" href="' . $slugUrl . '">';
        $seoTags .= '<meta property="og:locale" content="' . app()->getLocale() . '">';
        $seoTags .= $pageType->generateJsonLd($this)->toScriptTag();
        
        foreach ($this->generateOpenGraphTags($slugUrl) as $tag => $content) {
            $seoTags .= '<meta property="' . $tag . '" content="' . $content . '">';
        }
        
        foreach ($this->generateTwitterTags($slugUrl) as $tag => $content) {
            $seoTags .= '<meta name="' . $tag . '" content="' . $content . '">';
        }

        return $seoTags;
    }

    private function generateOpenGraphTags($slugUrl)
    {
        $openGraph = [
            'og:title' => $this->seo_title ?? $this->title,
            'og:description' => $this->seo_description,
            'og:url' => $slugUrl,
            'og:type' => 'website',
            'og:locale' => app()->getLocale(),
        ];

        if ($this->featured_image) {
            $openGraph['og:image'] = $this->getFeaturedImageUrl();
        }

        return $openGraph;
    }

    private function generateTwitterTags($slugUrl)
    {
        $twitter = [
            'twitter:card' => 'summary_large_image',
            'twitter:title' => $this->seo_title ?? $this->title,
            'twitter:description' => $this->seo_description,
            'twitter:url' => $slugUrl,
        ];

        if ($this->featured_image) {
            $twitter['twitter:image'] = $this->getFeaturedImageUrl();
        }

        return $twitter;
    }
}