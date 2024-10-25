<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

trait HasBlockAssets
{
    protected array $blockAssets = [
        'js' => [],
        'css' => [],
    ];

    public function addBlockJs(string $jsFile): self
    {
        $this->blockAssets['js'][] = $jsFile;

        return $this;
    }

    public function addBlockCss(string $cssFile): self
    {
        $this->blockAssets['css'][] = $cssFile;

        return $this;
    }

    public function getBlockJs(): array
    {
        return $this->blockAssets['js'];
    }

    public function getBlockCss(): array
    {
        return $this->blockAssets['css'];
    }

    public function registerBlockAssets($block)
    {
        $this->blockAssets = array_merge_recursive($this->blockAssets, $block->getAssets());

        return $this;
    }

    public function getBlockAssetsLinks()
    {
        $links = [];
        foreach ($this->getBlockJs() as $jsFile) {
            $links[] = '<script src="'.$jsFile.'"></script>';
        }
        foreach ($this->getBlockCss() as $cssFile) {
            $links[] = '<link rel="stylesheet" href="'.$cssFile.'">';
        }

        return implode("\n", $links);
    }
}
