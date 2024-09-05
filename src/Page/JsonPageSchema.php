<?php

namespace Raakkan\OnlyLaravel\Page;

class JsonPageSchema
{
    protected $schema = [];
    protected $propertyData = [];

    public function __construct()
    {
        $this->initializeBaseSchema();
    }

    protected function initializeBaseSchema()
    {
        $this->schema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
        ];
    }

    public function setType($type)
    {
        $this->schema['@type'] = $type;
        return $this;
    }

    public function setProperty($key, $value)
    {
        $this->schema[$key] = $value;
        return $this;
    }

    public function removeProperty($key)
    {
        unset($this->schema[$key]);
        return $this;
    }

    public function getSchema()
    {
        return $this->schema;
    }

    public function toJson()
    {
        return json_encode($this->schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    public function toScriptTag()
    {
        $json = $this->toJson();
        return "<script type=\"application/ld+json\">\n{$json}\n</script>";
    }
}
