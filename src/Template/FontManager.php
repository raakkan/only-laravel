<?php

namespace Raakkan\OnlyLaravel\Template;

class FontManager
{
    protected $fontFamilies = [
        [
            'name' => 'Arial',
            'value' => 'Arial, sans-serif'
        ],
        [
            'name' => 'Helvetica',
            'value' => 'Helvetica, Arial, sans-serif'
        ],
        [
            'name' => 'Verdana',
            'value' => 'Verdana, Geneva, sans-serif'
        ],
        [
            'name' => 'Tahoma',
            'value' => 'Tahoma, Geneva, sans-serif'
        ],
        [
            'name' => 'Times New Roman',
            'value' => '"Times New Roman", Times, serif'
        ],
        [
            'name' => 'Georgia',
            'value' => 'Georgia, serif'
        ],
        [
            'name' => 'Courier New',
            'value' => '"Courier New", Courier, monospace'
        ],
        [
            'name' => 'Roboto',
            'value' => 'Roboto, Arial, sans-serif'
        ],
    ];

    public function getLocalFontFamilies()
    {
        return $this->fontFamilies;
    }

    public function getGoogleFontFamilies()
    {
        return [
            'Inter',
            'Roboto',
            'Open Sans',
            'Lato',
        ];
    }

    public function getBunnyFontFamilies()
    {
        return [
            'Inter',
            'Roboto',
            'Open Sans',
            'Lato',
        ];
    }
}