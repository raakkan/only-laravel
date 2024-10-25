<?php

namespace Raakkan\OnlyLaravel\Page;

use App\Livewire\Pages\HomePage;
use Raakkan\OnlyLaravel\Models\PageModel;
use Raakkan\OnlyLaravel\Page\Concerns\HasSlug;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;
use Raakkan\OnlyLaravel\Page\Concerns\HasPageType;
use Raakkan\OnlyLaravel\Page\Concerns\HasTemplate;
use Raakkan\OnlyLaravel\Support\Concerns\HasTitle;
use Raakkan\OnlyLaravel\Page\Concerns\HasPageModel;
use Raakkan\OnlyLaravel\Page\Concerns\HasJsonSchema;
use Raakkan\OnlyLaravel\Template\Concerns\Deletable;
use Raakkan\OnlyLaravel\Page\Concerns\HasPageEditable;
use Raakkan\OnlyLaravel\Page\Concerns\ManagePageRoute;
use Raakkan\OnlyLaravel\Template\Concerns\Disableable;
use Raakkan\OnlyLaravel\Page\Concerns\ManagePageRender;
use Raakkan\OnlyLaravel\Page\Concerns\ManagesMiddleware;

// add option for disable some translation pages ex: en, ta 
// for example, if we have a page with name "Home" and we want to disable it for some languages, we can do it by 
// adding the language code to the page model settings
class BasePage
{
    use Makable;
    use HasTitle;
    use HasName;
    use HasSlug;
    use ManagePageRender;
    use HasTemplate;
    use Disableable;
    use Deletable;
    use HasPageEditable;
    use ManagesMiddleware;
    use ManagePageRoute;
    use HasPageModel;
    use HasJsonSchema;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function create()
    {
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
