<?php

namespace Raakkan\OnlyLaravel\Template\Models;

use Carbon\Carbon;

class DummyPageModel
{
    public $for = 'home-page';
    public $id = 1;
    public $name = 'Sample Page';
    public $template_id = 1;
    public $settings = ['show_header' => true, 'show_footer' => true];
    public $indexable = true;
    public $disabled = false;
    public $created_at;
    public $updated_at;
    public $featured_image = [
        'image' => 'pages/sample-featured-image.jpg',
        'alt' => 'Sample Featured Image'
    ];
    protected $custom_data = [];
    protected $locale;

    public $multilingual_data = [
        'title' => ['en' => 'Sample Page Title', 'es' => 'Título de Página de Muestra'],
        'slug' => ['en' => 'sample-page', 'es' => 'pagina-de-muestra'],
        'content' => ['en' => 'This is a sample page content.', 'es' => 'Este es el contenido de una página de muestra.'],
    ];

    public function __construct()
    {
        $this->locale = app()->getLocale();
        $this->created_at = Carbon::now();
        $this->updated_at = Carbon::now();
    }

    public static function make(string $for)
    {
        $instance = new self();
        $instance->setFor($for);
        return $instance;
    }

    public function update($attributes = [])
    {
        foreach ($attributes as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            } else {
                $this->custom_data[$key] = $value;
            }
        }
    }

    public function setFor($for)
    {
        $this->for = $for;
        return $this;
    }

    public function getFor()
    {
        return $this->for;
    }

    public function getTable()
    {
        return 'dummy_pages';
    }

    public function getName()
    {
        return $this->name;
    }

    public static function findBySlug($slug)
    {
        // This method would normally query a database, but for this dummy class, we'll just return the instance if the slug matches
        $instance = new self();
        if ($instance->slug['en'] === $slug || $instance->slug['es'] === $slug) {
            return $instance;
        }
        return null;
    }

    public function getSlugUrl()
    {
        return 'https://example.com/' . $this->slug['en'];
    }

    public static function getAccessebleAttributes()
    {
        return [
            'name' => 'Name',
            'title' => 'Title',
            'slug' => 'Slug',
            'content' => 'Content',
        ];
    }

    public function template()
    {
        // In a real scenario, this would return a related template model
        // For this dummy class, we'll just return an array with some template data
        return [
            'id' => $this->template_id,
            'name' => 'Default Template',
            'path' => 'templates.default',
        ];
    }

    public function getFeaturedImageUrl(): ?string
    {
        if (isset($this->featured_image['image'])) {
            return $this->featured_image['image'];
        }
        return null;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->multilingual_data)) {
            return $this->getLocalizedAttribute($name);
        }

        if (array_key_exists($name, $this->custom_data)) {
            return $this->custom_data[$name];
        }

        // You might want to throw an exception here, or return null
        // depending on how you want to handle undefined properties
        return null;
    }

    public function getLocalizedAttribute($attribute, $locale = null)
    {
        $locale = $locale ?: $this->locale;
        
        if (isset($this->multilingual_data[$attribute][$locale])) {
            return $this->multilingual_data[$attribute][$locale];
        }
        
        return $this->multilingual_data[$attribute]['en'] ?? null;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    public function __set($name, $value)
    {
        $this->custom_data[$name] = $value;
    }

    public function setCustomData($key, $value)
    {
        $this->custom_data[$key] = $value;
    }

    public function addData(array $data)
    {
        foreach ($data as $key => $value) {
            if ($key === 'featured_image') {
                $this->featured_image = $value;
            } elseif (array_key_exists($key, $this->multilingual_data)) {
                if (is_array($value)) {
                    foreach ($value as $locale => $translatedValue) {
                        $this->multilingual_data[$key][$locale] = $translatedValue;
                    }
                } else {
                    // If not an array, assume it's for the default locale
                    $this->multilingual_data[$key][app()->getLocale()] = $value;
                }
            } else {
                $this->setCustomData($key, $value);
            }
        }
        return $this;
    }

    public function getAllCustomData()
    {
        return $this->custom_data;
    }
}