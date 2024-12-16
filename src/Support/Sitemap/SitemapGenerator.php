<?php

namespace Raakkan\OnlyLaravel\Support\Sitemap;

use Illuminate\Support\Facades\File;
use Raakkan\OnlyLaravel\Models\PageModel;

class SitemapGenerator
{
    use HandleModels;

    protected $indexFolderUrl = '/sitemaps/';

    public function generate()
    {
        $models = array_merge($this->models, [PageModel::class]);
        $this->generateSitemapIndex();
        foreach ($models as $model) {
            $this->generateModelSitemap($model);
        }
    }

    protected function generateSitemapIndex(): string
    {
        $models = array_merge($this->models, [PageModel::class]);
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
        $xml .= '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;

        foreach ($models as $model) {
            $xml .= "\t<sitemap>".PHP_EOL;
            $xml .= "\t\t<loc>".url($this->indexFolderUrl."{$this->getModelName($model)}.xml").'</loc>'.PHP_EOL;
            $xml .= "\t\t<lastmod>".now()->toW3cString().'</lastmod>'.PHP_EOL;
            $xml .= "\t</sitemap>".PHP_EOL;
        }

        $xml .= '</sitemapindex>';

        // Create sitemap index file in public folder
        File::put(public_path('sitemap.xml'), $xml);

        return $xml;
    }

    protected function generateModelSitemap(string $model): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL;
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'.PHP_EOL;

        $items = $model::all();
        foreach ($items as $item) {
            $xml .= "\t<url>".PHP_EOL;
            $xml .= "\t\t<loc>".url($item->slug).'</loc>'.PHP_EOL;
            $xml .= "\t\t<lastmod>".$item->updated_at->toW3cString().'</lastmod>'.PHP_EOL;
            $xml .= "\t\t<changefreq>daily</changefreq>".PHP_EOL;
            $xml .= "\t\t<priority>0.8</priority>".PHP_EOL;
            $xml .= "\t</url>".PHP_EOL;
        }

        $xml .= '</urlset>';

        // Create sitemaps directory if it doesn't exist
        $sitemapsPath = public_path('sitemaps');
        if (! File::exists($sitemapsPath)) {
            File::makeDirectory($sitemapsPath, 0755, true);
        }

        // Save model sitemap in sitemaps folder
        File::put($sitemapsPath.'/'.$this->getModelName($model).'.xml', $xml);

        return $xml;
    }

    protected function getModelName(string $model): string
    {
        if (method_exists($model, 'getSitemapName')) {
            return $model::getSitemapName();
        }

        return strtolower(class_basename($model));
    }

    protected function getIndexFolderUrl(): string
    {
        return $this->indexFolderUrl;
    }

    public function setIndexFolderUrl(string $url): self
    {
        $this->indexFolderUrl = $url;

        return $this;
    }
}
