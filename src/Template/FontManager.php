<?php

namespace Raakkan\OnlyLaravel\Template;

class FontManager
{
    protected $fontFamilies = [
        [
            'name' => 'Arial',
            'value' => 'Arial, Helvetica, sans-serif'
        ],
        [
            'name' => 'Arial Black',
            'value' => 'Arial Black, Gadget, sans-serif'
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
            'name' => 'Trebuchet MS',
            'value' => '"Trebuchet MS", Helvetica, sans-serif'
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
    ];

    public function getFontFamilies()
    {
        return $this->fontFamilies;
    }
}