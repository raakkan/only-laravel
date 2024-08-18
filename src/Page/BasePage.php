<?php

namespace Raakkan\OnlyLaravel\Pages;

use Raakkan\OnlyLaravel\Support\Concerns\HasName;
use Raakkan\OnlyLaravel\Support\Concerns\HasSlug;
use Raakkan\OnlyLaravel\Support\Concerns\Makable;
use Raakkan\OnlyLaravel\Support\Concerns\HasTitle;

class BasePage
{
    use Makable;
    use HasTitle;
    use HasName;
    use HasSlug;
}
