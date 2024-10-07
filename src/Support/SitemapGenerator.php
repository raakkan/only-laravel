<?php

namespace Raakkan\OnlyLaravel\Support;

use Raakkan\OnlyLaravel\Facades\PageManager;
use Illuminate\Support\Facades\File;

class SitemapGenerator
{
    protected $sitemaps = [];
    protected $rootSitemap = [];
    protected $sitemapPath = 'sitemaps';

    public function generate()
    {
        $this->generatePageTypeSitemaps();
        $this->generateIndexSitemap();
        $this->writeSitemapFiles();

        return [
            'index' => $this->sitemaps['index'],
            'root' => $this->rootSitemap,
            'page_types' => array_diff_key($this->sitemaps, ['index' => true]),
        ];
    }

    protected function generatePageTypeSitemaps()
    {
        $models = array_filter(PageManager::getAllModels(), 'is_string');

        foreach ($models as $model) {
            
            $sitemap = [];
            $data = $model::get();
            foreach ($data as $item) {
                $pageType = PageManager::findPageTypeByType($item->getPageType());
                if (!$pageType->isExternalModelPage($item->slug)) {
                    $sitemapEntry = [
                        'loc' => $pageType->generateUrl($item->slug),
                        'lastmod' => $item->updated_at->toAtomString(),
                        'changefreq' => 'weekly',
                        'priority' => 0.8,
                    ];

                    if ($pageType->getLevel() === 'root') {
                        $this->rootSitemap[] = $sitemapEntry;
                    } else {
                        $sitemap[] = $sitemapEntry;
                    }
                }
            }

            if (!empty($sitemap)) {
                $this->sitemaps[$pageType->getType()] = $sitemap;
            }
        }
    }

    protected function generateIndexSitemap()
    {
        $indexSitemap = [];

        // Add root sitemap to the index
        $indexSitemap[] = [
            'loc' => url("{$this->sitemapPath}/pages.xml"),
            'lastmod' => now()->toAtomString(),
        ];

        foreach ($this->sitemaps as $pageType => $sitemap) {
            if ($pageType !== 'index') {
                $indexSitemap[] = [
                    'loc' => url("{$this->sitemapPath}/sitemap-{$pageType}.xml"),
                    'lastmod' => now()->toAtomString(),
                ];
            }
        }

        $this->sitemaps['index'] = $indexSitemap;
    }

    protected function writeSitemapFiles()
    {
        $publicPath = public_path();
        $sitemapDir = "{$publicPath}/{$this->sitemapPath}";

        // Ensure the sitemaps directory exists
        if (!File::isDirectory($sitemapDir)) {
            File::makeDirectory($sitemapDir, 0755, true);
        }

        // Write index sitemap
        $indexContent = $this->generateXmlSitemap($this->sitemaps['index'], true);
        File::put("{$sitemapDir}/sitemap.xml", $indexContent);

        // Write root sitemap
        if (!empty($this->rootSitemap)) {
            $rootContent = $this->generateXmlSitemap($this->rootSitemap);
            File::put("{$sitemapDir}/sitemap-root.xml", $rootContent);
        }

        // Write page type sitemaps
        foreach ($this->sitemaps as $pageType => $sitemap) {
            if ($pageType !== 'index') {
                $content = $this->generateXmlSitemap($sitemap);
                File::put("{$sitemapDir}/sitemap-{$pageType}.xml", $content);
            }
        }
    }

    protected function generateXmlSitemap($sitemap, $isIndex = false)
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $xml .= $isIndex
            ? '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL
            : '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        foreach ($sitemap as $entry) {
            $xml .= $isIndex ? '  <sitemap>' . PHP_EOL : '  <url>' . PHP_EOL;
            foreach ($entry as $key => $value) {
                $xml .= "    <{$key}>" . htmlspecialchars($value) . "</{$key}>" . PHP_EOL;
            }
            $xml .= $isIndex ? '  </sitemap>' . PHP_EOL : '  </url>' . PHP_EOL;
        }

        $xml .= $isIndex ? '</sitemapindex>' : '</urlset>';

        return $xml;
    }
}

