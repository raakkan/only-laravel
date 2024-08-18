<?php

namespace Raakkan\OnlyLaravel\Page;

use App\Livewire\Pages\HomePage;
use Raakkan\OnlyLaravel\Models\PageModel;
use Raakkan\OnlyLaravel\Page\Concerns\ManagePages;
use Raakkan\OnlyLaravel\Page\Concerns\ManagePageRender;

class PageManager
{
    use ManagePageRender;
    use ManagePages;

    public function getPageTables()
    {
        return ['pages'];
    }

    public function homePage()
    {
        return $this->getPageByName('home-page')->render();
    }
}
