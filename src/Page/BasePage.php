<?php

namespace Raakkan\OnlyLaravel\Page;

use Raakkan\OnlyLaravel\Page\Concerns\HasJsonSchema;
use Raakkan\OnlyLaravel\Page\Concerns\HasPageEditable;
use Raakkan\OnlyLaravel\Page\Concerns\HasPageModel;
use Raakkan\OnlyLaravel\Page\Concerns\HasSlug;
use Raakkan\OnlyLaravel\Page\Concerns\HasTemplate;
use Raakkan\OnlyLaravel\Page\Concerns\ManagePageRender;
use Raakkan\OnlyLaravel\Page\Concerns\ManagePageRoute;
use Raakkan\OnlyLaravel\Page\Concerns\ManagesMiddleware;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\HasTitle;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;
use Raakkan\OnlyLaravel\Template\Concerns\Deletable;
use Raakkan\OnlyLaravel\Template\Concerns\Disableable;

// add option for disable some translation pages ex: en, ta
// for example, if we have a page with name "Home" and we want to disable it for some languages, we can do it by
// adding the language code to the page model settings
class BasePage
{
    use Deletable;
    use Disableable;
    use HasJsonSchema;
    use HasName;
    use HasPageEditable;
    use HasPageModel;
    use HasSlug;
    use HasTemplate;
    use HasTitle;
    use Makable;
    use ManagePageRender;
    use ManagePageRoute;
    use ManagesMiddleware;

    protected $isRoot = false;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function isRoot()
    {
        return $this->isRoot;
    }

    public function root()
    {
        $this->isRoot = true;

        return $this;
    }

    public function create()
    {
        if($this instanceof DynamicPage) {
            return;
        }

        $modelClass = $this->getModelClass();

        if ($modelClass::where('name', $this->name)->exists()) {
            return;
        }

        if ($this->hasTemplate()) {
            $this->createTemplate();
        }

        // Get fillable attributes
        $fillable = (new $modelClass)->getFillable();

        // Prepare data for creation
        $data = [
            'name' => $this->name,
            'title' => $this->title,
            'slug' => trim($this->slug, '/'),
            'disabled' => $this->disabled,
            'template_id' => $this->getTemplateModel()->id ?? null,
            ...$this->getModelData(),
        ];

        // Filter data to only include fillable attributes
        $filteredData = array_intersect_key($data, array_flip($fillable));

        $page = $modelClass::create($filteredData);

        $this->setModel($page);

        return $page;
    }
}
