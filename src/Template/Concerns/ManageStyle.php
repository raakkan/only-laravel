<?php

namespace Raakkan\OnlyLaravel\Template\Concerns;

use Illuminate\Support\Facades\File;

// TODO: dont include disabled blocks or components
trait ManageStyle
{
    public function buildCss()
    {
        $css = $this->getAllBlocksCustomCss().' '.$this->getCssClassesFromBlocksViews().' '.$this->getCustomCss().' '.$this->getContainerCssClasses();
        $tailwind = \Raakkan\PhpTailwind\PhpTailwind::make();
        $tailwind->parse($css);
        $tailwind->includePreflight();
        $tailwind->minify();
        $css = $tailwind->toString();

        // Save CSS to file
        $this->saveCssToFile($css);

        return $tailwind;
    }

    protected function saveCssToFile($css)
    {
        $directory = public_path('css/templates');
        $filename = $this->getCssFilename();
        $filePath = $directory.'/'.$filename;

        // Create directory if it doesn't exist
        if (! File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        // Save CSS content to file
        File::put($filePath, $css);
    }

    protected function getCssFilename()
    {
        return $this->getSanitizedName().'.css';
    }

    public function getCssClassesFromBlocksViews()
    {
        $cssClasses = collect();

        $viewPaths = $this->getBlockViewPaths();

        foreach ($viewPaths as $viewPath) {
            if (File::isFile($viewPath)) {
                $content = File::get($viewPath);

                // 1. Extract regular class attributes and blade expressions
                preg_match_all('/class\s*=\s*["\']([^"\']*(?:\{\{[^}]*\}\}[^"\']*)*)["\']/', $content, $classMatches);
                foreach ($classMatches[1] as $classString) {
                    $processedClasses = $this->processClassString($classString);
                    $cssClasses = $cssClasses->merge($processedClasses);
                }

                // 2. Extract classes from Blade if/else conditions
                preg_match_all('/@if\s*\((.*?)\)(.*?)(?:@else(.*?))?@endif/s', $content, $ifMatches, PREG_SET_ORDER);
                foreach ($ifMatches as $match) {
                    // Process classes in the if block
                    preg_match_all('/class\s*=\s*["\']([^"\']*)["\']/', $match[2], $ifClassMatches);
                    foreach ($ifClassMatches[1] as $classString) {
                        $processedClasses = $this->processClassString($classString);
                        $cssClasses = $cssClasses->merge($processedClasses);
                    }

                    // Process classes in the else block if it exists
                    if (! empty($match[3])) {
                        preg_match_all('/class\s*=\s*["\']([^"\']*)["\']/', $match[3], $elseClassMatches);
                        foreach ($elseClassMatches[1] as $classString) {
                            $processedClasses = $this->processClassString($classString);
                            $cssClasses = $cssClasses->merge($processedClasses);
                        }
                    }
                }

                // 3. Extract classes from string concatenation in class attributes
                preg_match_all('/class\s*=\s*["\']([^"\']*\{\{[^}]*\}\}[^"\']*)["\']/', $content, $concatMatches);
                foreach ($concatMatches[1] as $classString) {
                    // Remove blade expressions but keep the spaces
                    $cleanString = preg_replace('/\{\{(.*?)\}\}/', ' ', $classString);
                    $processedClasses = $this->processClassString($cleanString);
                    $cssClasses = $cssClasses->merge($processedClasses);
                }

                // 4. Extract dynamic classes from ternary operations in class attributes
                preg_match_all('/class\s*=\s*["\'].*?\?\s*\'([^\']+)\'\s*:\s*\'([^\']+)\'.*?["\']/', $content, $ternaryMatches);
                foreach ($ternaryMatches[1] as $index => $trueClasses) {
                    $falseClasses = $ternaryMatches[2][$index];
                    $processedTrueClasses = $this->processClassString($trueClasses);
                    $processedFalseClasses = $this->processClassString($falseClasses);
                    $cssClasses = $cssClasses->merge($processedTrueClasses)->merge($processedFalseClasses);
                }

                // 5. Extract transition classes
                preg_match_all('/x-transition(?:[:.][a-zA-Z-]+)*(?:\s*=\s*["\'][^"\']*["\'])?/', $content, $transitionMatches);
                foreach ($transitionMatches[0] as $transitionDirective) {
                    $transitionClasses = $this->extractTransitionClasses($transitionDirective);
                    $processedClasses = $this->processClassString($transitionClasses);
                    $cssClasses = $cssClasses->merge($processedClasses);
                }

                // Also extract x-transition:enter/leave classes
                preg_match_all('/x-transition(?::[a-z-]+)?\s*=\s*["\']([^"\']+)["\']/', $content, $transitionAttrMatches);
                foreach ($transitionAttrMatches[1] as $classString) {
                    $processedClasses = $this->processClassString($classString);
                    $cssClasses = $cssClasses->merge($processedClasses);
                }

                // Enhanced pattern for @if/@elseif/@else conditions in class attributes
                preg_match_all('/class=["\'].*?@if\s*\((.*?)\)\s*(.*?)(?:@elseif\s*\((.*?)\)\s*(.*?))*(?:@else\s*(.*?))?@endif.*?["\']/', $content, $conditionalMatches, PREG_SET_ORDER);
                foreach ($conditionalMatches as $match) {
                    // Extract all possible class combinations
                    foreach ($match as $condition) {
                        // Extract background classes and other utility classes
                        preg_match_all('/bg-[a-z]+-\d+|[a-z]+-\d+/', $condition, $utilityMatches);
                        if (! empty($utilityMatches[0])) {
                            $cssClasses = $cssClasses->merge($utilityMatches[0]);
                        }
                    }
                }

                // Additional pattern for direct class assignments
                preg_match_all('/class=["\']([^"\']*)["\']/', $content, $directClasses);
                foreach ($directClasses[1] as $classString) {
                    $processedClasses = $this->processClassString($classString);
                    $cssClasses = $cssClasses->merge($processedClasses);
                }

                // Add specific handling for dynamic background classes
                preg_match_all('/bg-[a-z]+-\d+/', $content, $bgMatches);
                if (! empty($bgMatches[0])) {
                    $cssClasses = $cssClasses->merge($bgMatches[0]);
                }
            }
        }

        // Add new section to process Blade::render content from blocks
        foreach ($this->blocks as $block) {
            if (method_exists($block, 'render')) {
                $reflection = new \ReflectionMethod($block, 'render');
                $content = file_get_contents($reflection->getFileName());

                // Extract content between Blade::render(<<<'blade' and blade,
                preg_match_all("/Blade::render\(<<<'blade'\s*(.*?)\s*blade,/s", $content, $bladeMatches);

                foreach ($bladeMatches[1] as $bladeContent) {
                    // Process class attributes in the Blade content
                    preg_match_all('/class\s*=\s*["\']([^"\']*(?:\{\{[^}]*\}\}[^"\']*)*)["\']/', $bladeContent, $classMatches);
                    foreach ($classMatches[1] as $classString) {
                        $processedClasses = $this->processClassString($classString);
                        $cssClasses = $cssClasses->merge($processedClasses);
                    }
                }
            }
        }

        return $cssClasses->unique()->implode(' ');
    }

    protected function processClassString($classString)
    {
        // Remove blade expressions but preserve spaces
        $classString = preg_replace('/\{\{.*?\}\}/', ' ', $classString);

        // Remove any quotes and extra whitespace
        $classString = trim(str_replace(["'", '"'], '', $classString));

        // Split the string into individual classes
        $classes = preg_split('/\s+/', $classString, -1, PREG_SPLIT_NO_EMPTY);

        // Clean up each class
        $classes = array_map(function ($class) {
            $class = trim($class);
            // Remove any PHP/Blade expressions
            $class = preg_replace('/\$[a-zA-Z0-9_\->]+(?:\([^)]*\))?/', '', $class);

            return $class;
        }, $classes);

        // Filter out empty classes and expressions
        return array_filter($classes, function ($class) {
            return $class && ! str_contains($class, '{{') && ! str_contains($class, '}}');
        });
    }

    protected function extractTransitionClasses($transitionDirective)
    {
        $classes = [];

        // Base transition classes
        if (str_contains($transitionDirective, 'x-transition')) {
            $classes = array_merge($classes, [
                'enter', 'enter-start', 'enter-end',
                'leave', 'leave-start', 'leave-end',
            ]);
        }

        // Extract specific transition modifiers
        $modifierMap = [
            'opacity' => ['opacity-0', 'opacity-100'],
            'scale' => ['scale-0', 'scale-90', 'scale-100'],
            'slide-top' => ['translate-y-0', '-translate-y-full'],
            'slide-bottom' => ['translate-y-0', 'translate-y-full'],
            'slide-left' => ['translate-x-0', '-translate-x-full'],
            'slide-right' => ['translate-x-0', 'translate-x-full'],
        ];

        foreach ($modifierMap as $modifier => $modifierClasses) {
            if (str_contains($transitionDirective, $modifier)) {
                $classes = array_merge($classes, $modifierClasses);
            }
        }

        // Extract duration classes
        if (preg_match('/duration-(\d+)/', $transitionDirective, $matches)) {
            $classes[] = 'duration-'.$matches[1];
        }

        // Extract delay classes
        if (preg_match('/delay-(\d+)/', $transitionDirective, $matches)) {
            $classes[] = 'delay-'.$matches[1];
        }

        // Extract ease classes
        $easeTypes = ['linear', 'in', 'out', 'in-out'];
        foreach ($easeTypes as $ease) {
            if (str_contains($transitionDirective, 'ease-'.$ease)) {
                $classes[] = 'ease-'.$ease;
            }
        }

        // Extract custom classes from x-transition directives
        preg_match_all('/x-transition[:](?:enter|leave)(?:-start|-end)?\s*=\s*["\']([^"\']+)["\']/', $transitionDirective, $matches);
        foreach ($matches[1] as $customClasses) {
            $classes = array_merge($classes, explode(' ', $customClasses));
        }

        return implode(' ', array_unique(array_filter($classes)));
    }
}
