<?php

namespace Raakkan\OnlyLaravel\Theme\Template;

class TemplateManager
{
    public function saveTemplates($templates)
    {
        foreach ($templates as $template) {
            $template->save();
        }
    }
}
