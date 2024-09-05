<?php

namespace Raakkan\OnlyLaravel\Support\Concerns;
use Raakkan\OnlyLaravel\Facades\PageManager;

trait HasSeoTags
{
    public function getSeoTags()
    {
        $pageType = PageManager::findPageTypeByType($this->pageType);
        $seoTags = '';

        $seoTags .= '<title>' . ($this->seo_title ?? $this->title) . '</title>';
        $seoTags .= '<meta name="description" content="' . $this->seo_description . '">';
        $seoTags .= '<meta name="keywords" content="' . $this->seo_keywords . '">';
        
        if ($this->getFeaturedImageUrl()) {
            $seoTags .= '<meta property="og:image" content="' . $this->getFeaturedImageUrl() . '">';
        }

        $slugUrl = $this->name == 'home-page' ? url('/') : $pageType->generateUrl($this->slug);
        
        $seoTags .= '<link rel="canonical" href="' . $slugUrl . '">';
        $seoTags .= '<meta property="og:locale" content="' . app()->getLocale() . '">';
        $seoTags .= '<script type="application/ld+json">' . $this->generateJsonLd() . '</script>';
        
        foreach ($this->generateOpenGraphTags() as $tag => $content) {
            $seoTags .= '<meta property="' . $tag . '" content="' . $content . '">';
        }
        
        foreach ($this->generateTwitterTags() as $tag => $content) {
            $seoTags .= '<meta name="' . $tag . '" content="' . $content . '">';
        }

        return $seoTags;
    }

    private function generateJsonLd()
    {
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            '@id' => url($this->slug),
            'name' => $this->seo_title ?? $this->title,
            'description' => $this->seo_description,
            'url' => url($this->slug),
        ];

        if ($this->featured_image) {
            $jsonLd['image'] = $this->getFeaturedImageUrl();
        }

        return json_encode($jsonLd);
    }

    private function generateOpenGraphTags()
    {
        $openGraph = [
            'og:title' => $this->seo_title ?? $this->title,
            'og:description' => $this->seo_description,
            'og:url' => url($this->slug),
            'og:type' => 'website',
            'og:locale' => app()->getLocale(),
        ];

        if ($this->featured_image) {
            $openGraph['og:image'] = $this->getFeaturedImageUrl();
        }

        return $openGraph;
    }

    private function generateTwitterTags()
    {
        $twitter = [
            'twitter:card' => 'summary_large_image',
            'twitter:title' => $this->seo_title ?? $this->title,
            'twitter:description' => $this->seo_description,
            'twitter:url' => url($this->slug),
        ];

        if ($this->featured_image) {
            $twitter['twitter:image'] = $this->getFeaturedImageUrl();
        }

        return $twitter;
    }
}