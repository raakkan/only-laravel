<?php

namespace Raakkan\OnlyLaravel\Page;

use App\Livewire\Pages\HomePage;
use Raakkan\OnlyLaravel\Models\PageModel;
use Raakkan\OnlyLaravel\Page\Concerns\HasTemplate;
use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\HasSlug;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;
use Raakkan\OnlyLaravel\Support\Concerns\HasTitle;
use Raakkan\OnlyLaravel\Page\Concerns\ManagePageRender;
use Raakkan\OnlyLaravel\Template\Concerns\Deletable;
use Raakkan\OnlyLaravel\Template\Concerns\Disableable;

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

    protected $view = '';
    protected $livewire = '';

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

    public function livewire($component)
    {
        $this->livewire = $component;

        return $this;
    }

    public function render()
    {
        $page = $this->getModel();

        if ($page->disabled) {
            return abort(404);
        }

        if ($this->livewire) {
            return $this->renderLivewire($this->livewire, ['page' => $page]);
        }

        return view($this->view, [
            'page' => PageModel::where('name', $this->getName())->with('template')->first(),
        ]);
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
            'template_id' => $this->getTemplate()->id ?? null,
        ]);
    }
}
