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

class BasePage
{
    use Makable;
    use HasTitle;
    use HasName;
    use HasSlug;
    use ManagePageRender;
    use HasTemplate;

    protected $view = '';
    protected $livewire = '';

    public function livewire($component)
    {
        $this->livewire = $component;

        return $this;
    }

    public function render()
    {
        if ($this->livewire) {
            return $this->renderLivewire($this->livewire, ['page' => PageModel::where('name', $this->getName())->with('template')->first()]);
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
            'slug' => $this->slug,
            'template_id' => $this->getTemplate()->id,
        ]);
    }
}
