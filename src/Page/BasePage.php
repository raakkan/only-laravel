<?php

namespace Raakkan\OnlyLaravel\Page;

use App\Livewire\Pages\HomePage;
use Raakkan\OnlyLaravel\Models\PageModel;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\HasSlug;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;
use Raakkan\OnlyLaravel\Page\Concerns\HasPageType;
use Raakkan\OnlyLaravel\Page\Concerns\HasTemplate;
use Raakkan\OnlyLaravel\Support\Concerns\HasTitle;
use Raakkan\OnlyLaravel\Template\Concerns\Deletable;
use Raakkan\OnlyLaravel\Page\Concerns\HasPageEditable;
use Raakkan\OnlyLaravel\Template\Concerns\Disableable;
use Raakkan\OnlyLaravel\Page\Concerns\ManagePageRender;

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
    use HasPageType;
    use HasPageEditable;

    protected $model;
    protected $modelClass = PageModel::class;
    protected $modelData = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function setModel($model, $save = true)
    {
        $this->model = $model;
        
        return $this;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function hasModel()
    {
        return isset($this->model);
    }

    public function getModelClass()
    {
        return $this->modelClass;
    }

    public function setModelClass($modelClass)
    {
        $this->modelClass = $modelClass;
        return $this;
    }

    public function setModelData($modelData)
    {
        $this->modelData = $modelData;
        return $this;
    }

    public function getModelData()
    {
        return $this->modelData;
    }

    public function create()
    {
        $modelClass = $this->getModelClass();

        if ($modelClass::where('name', $this->name)->exists()) {
            return;
        }

        $page = $modelClass::create([
            'name' => $this->name,
            'type' => $this->getPageType(),
            'title' => $this->title,
            'slug' => trim($this->slug, '/'),
            'disabled' => $this->disabled,
            'template_id' => $this->getTemplateModel()->id ?? null,
            ...$this->getModelData(),
        ]);

        $this->setModel($page);

        return $page;
    }
}
