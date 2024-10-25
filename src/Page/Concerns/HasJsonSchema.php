<?php

namespace Raakkan\OnlyLaravel\Page\Concerns;

use Raakkan\OnlyLaravel\Page\JsonPageSchema;

trait HasJsonSchema
{
    protected $jsonSchema;

    public function registerJsonSchema(callable $callback)
    {
        $jsonSchema = new JsonPageSchema;
        $callback($jsonSchema);
        $this->jsonSchema = $jsonSchema;

        return $this;
    }

    public function generateJsonLd($pageModel, $page)
    {
        if ($this->jsonSchema) {
            return $this->jsonSchema->generateJsonLd($pageModel, $page);
        }

        return null;
    }
}
