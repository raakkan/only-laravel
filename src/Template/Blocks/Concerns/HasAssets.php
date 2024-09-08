<?php

namespace Raakkan\OnlyLaravel\Template\Blocks\Concerns;

trait HasAssets
{
    protected array $assets = [
        'js' => [],
        'css' => [],
    ];

    public function addJs(string $jsFile): self
    {
        $this->assets['js'][] = $jsFile;
        return $this;
    }

    public function addCss(string $cssFile): self
    {
        $this->assets['css'][] = $cssFile;
        return $this;
    }

    public function getJs(): array
    {
        return $this->assets['js'];
    }

    public function getCss(): array
    {
        return $this->assets['css'];
    }

    public function getAssets(): array
    {
        if ($this->type == 'component') {
            return array_merge($this->assets, $this->getDesignVariantAssets());
        } else {
            return $this->assets;
        }
        
    }

    public function registerAssets(): void
    {
        $template = $this->getTemplate();
        
        foreach ($this->getJs() as $jsFile) {
            $template->addJs($jsFile);
        }

        foreach ($this->getCss() as $cssFile) {
            $template->addCss($cssFile);
        }
    }

}