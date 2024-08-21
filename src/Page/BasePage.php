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
use Raakkan\OnlyLaravel\Template\Concerns\Disableable;
use Raakkan\OnlyLaravel\Page\Concerns\ManagePageRender;

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

    protected $model;

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
    public function create()
    {
        if (PageModel::where('name', $this->name)->exists()) {
            return;
        }

        $page = PageModel::create([
            'name' => $this->name,
            'title' => $this->title,
            'slug' => trim($this->slug, '/'),
            'disabled' => $this->disabled,
            'page_type' => $this->getPageType(),
            'template_id' => $this->getTemplateModel()->id ?? null,
        ]);
    }
}
