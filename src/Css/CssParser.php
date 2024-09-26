<?php

namespace Raakkan\OnlyLaravel\Css;

class CssParser
{
    public static function parse()
    {
        $classes = 'p-0 px-1 py-1 ps-2 pe-2 pt-2 pb-2 pr-2 pl-2 po-3 m-0 mx-1 my-1 ms-2 me-2 mt-2 mb-2 mr-2 ml-2 mo-3';
        
        $paddingCss = self::parsePadding($classes);
        $marginCss = self::parseMargin($classes);

        dd($paddingCss . $marginCss);
    }

    public static function parsePadding($classes)
    {
        $rules = explode(' ', $classes);
        $parsedRules = [];

        $validClasses = ['p', 'x', 'y', 't', 'r', 'b', 'l', 's', 'e'];

        foreach ($rules as $rule) {
            preg_match('/([a-z-]+)-(\d+)/', $rule, $matches);
            if ($matches) {
                $class = $matches[1];
                if (strlen($class) == 2 && $class[0] == 'p') {
                    $class = $class[1];
                }
                $size = intval($matches[2]);
                if (in_array($class, $validClasses) && is_int($size)) {
                    $parsedRules[] = ['class' => $class, 'size' => $size];
                }
            }
        }
        
        $css = '';
        $paddingMap = [
            'p' => 'padding: %1$s;',
            'x' => 'padding-left: %1$s; padding-right: %1$s;',
            'y' => 'padding-top: %1$s; padding-bottom: %1$s;',
            't' => 'padding-top: %1$s;',
            'r' => 'padding-right: %1$s;',
            'b' => 'padding-bottom: %1$s;',
            'l' => 'padding-left: %1$s;',
            's' => 'padding-inline-start: %1$s;',
            'e' => 'padding-inline-end: %1$s;'
        ];

        foreach ($parsedRules as $parsedRule) {
            $class = $parsedRule['class'];
            $size = $parsedRule['size'];
            if (isset($paddingMap[$class])) {
                $className = $class === 'p' ? 'p' : 'p' . $class;
                $paddingValue = $size === 0 ? '0px' : ($size * 0.25) . 'rem';
                $css .= sprintf('.%s-%d{%s}', $className, $size, sprintf($paddingMap[$class], $paddingValue));
            }
        }

        return $css;
    }

    public static function parseMargin($classes)
    {
        $rules = explode(' ', $classes);
        $parsedRules = [];

        $validClasses = ['m', 'x', 'y', 't', 'r', 'b', 'l', 's', 'e'];

        foreach ($rules as $rule) {
            preg_match('/([a-z-]+)-(\d+)/', $rule, $matches);
            if ($matches) {
                $class = $matches[1];
                if (strlen($class) == 2 && $class[0] == 'm') {
                    $class = $class[1];
                }
                $size = intval($matches[2]);
                if (in_array($class, $validClasses) && is_int($size)) {
                    $parsedRules[] = ['class' => $class, 'size' => $size];
                }
            }
        }
        
        $css = '';
        $marginMap = [
            'm' => 'margin: %1$s;',
            'x' => 'margin-left: %1$s; margin-right: %1$s;',
            'y' => 'margin-top: %1$s; margin-bottom: %1$s;',
            't' => 'margin-top: %1$s;',
            'r' => 'margin-right: %1$s;',
            'b' => 'margin-bottom: %1$s;',
            'l' => 'margin-left: %1$s;',
            's' => 'margin-inline-start: %1$s;',
            'e' => 'margin-inline-end: %1$s;'
        ];

        foreach ($parsedRules as $parsedRule) {
            $class = $parsedRule['class'];
            $size = $parsedRule['size'];
            if (isset($marginMap[$class])) {
                $className = $class === 'm' ? 'm' : 'm' . $class;
                $marginValue = $size === 0 ? '0px' : ($size * 0.25) . 'rem';
                $css .= sprintf('.%s-%d{%s}', $className, $size, sprintf($marginMap[$class], $marginValue));
            }
        }

        return $css;
    }
}