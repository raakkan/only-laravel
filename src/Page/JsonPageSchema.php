<?php

namespace Raakkan\OnlyLaravel\Page;

class JsonPageSchema
{
    protected $schema = [];
    protected $dataInstructions = [];

    public function __construct()
    {
        $this->initializeBaseSchema();
    }

    protected function initializeBaseSchema()
    {
        $this->schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'WebPage',
                ],
                [
                    '@type' => 'WebSite',
                    '@id' => url('/') . '#website',
                    'url' => url('/'),
                ],
            ],
        ];
    }

    public function setType($type)
    {
        $this->schema['@graph'][0]['@type'] = $type;
        return $this;
    }

    public function setProperty($key, $value, $dataInstruction = [])
    {
        $this->schema['@graph'][0][$key] = $value;
        $this->dataInstructions[$key] = $dataInstruction;
        return $this;
    }

    public function removeProperty($key)
    {
        unset($this->schema['@graph'][0][$key]);
        unset($this->dataInstructions[$key]);
        return $this;
    }

    public function getSchema()
    {
        return $this->schema;
    }

    public function getDataInstructions()
    {
        return $this->dataInstructions;
    }

    public function toJson()
    {
        return json_encode($this->schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function toScriptTag()
    {
        $json = $this->toJson();
        return "<script type=\"application/ld+json\">\n{$json}\n</script>";
    }

    public function generateJsonLd($page, $pageType)
    {
        foreach ($this->dataInstructions as $key => $instruction) {
            if (isset($instruction['instruction']) && is_callable($instruction['instruction'])) {
                $this->schema['@graph'][0][$key] = call_user_func($instruction['instruction'], $page, $pageType);
            }
        }

        return $this;
    }
}