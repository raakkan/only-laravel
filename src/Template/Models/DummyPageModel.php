<?php

namespace Raakkan\OnlyLaravel\Template\Models;

class DummyPageModel
{
    public $for = 'home-page';
    public $id = 1;
    public $name = 'Sample Page';
    public $title = ['en' => 'Sample Page Title', 'es' => 'Título de Página de Muestra'];
    public $slug = ['en' => 'sample-page', 'es' => 'pagina-de-muestra'];
    public $content = ['en' => 'This is a sample page content.', 'es' => 'Este es el contenido de una página de muestra.'];
    public $template_id = 1;
    public $settings = ['show_header' => true, 'show_footer' => true];
    public $indexable = true;
    public $disabled = false;
    public $created_at = '2023-04-15 10:00:00';
    public $updated_at = '2023-04-15 10:00:00';
    public $featured_image = [
        'image' => 'pages/sample-featured-image.jpg',
        'alt' => 'Sample Featured Image'
    ];
    protected $custom_data = [];

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
            return 'https://example.com/storage/' . $this->featured_image['image'];
        }
        return null;
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->custom_data)) {
            return $this->custom_data[$name];
        }

        // You might want to throw an exception here, or return null
        // depending on how you want to handle undefined properties
        return null;
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
            $this->setCustomData($key, $value);
        }
    }

    public function getAllCustomData()
    {
        return $this->custom_data;
    }
}