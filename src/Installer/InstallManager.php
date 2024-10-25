<?php

namespace Raakkan\OnlyLaravel\Installer;

use Raakkan\OnlyLaravel\Installer\Steps\AdminAccountStep;
use Raakkan\OnlyLaravel\Installer\Steps\DatabaseStep;
use Raakkan\OnlyLaravel\Installer\Steps\FolderPermissionsStep;
use Raakkan\OnlyLaravel\Installer\Steps\RequirementsStep;
use Raakkan\OnlyLaravel\Installer\Steps\WebsiteInfoStep;

class InstallManager
{
    protected $steps = [];

    public function __construct()
    {
        $this->steps = [
            'requirements' => RequirementsStep::make(),
            'folder-permissions' => FolderPermissionsStep::make(),
            'database' => DatabaseStep::make(),
            'admin-account' => AdminAccountStep::make(),
            'website-info' => WebsiteInfoStep::make(),
        ];
    }

    public function getSteps()
    {
        return $this->steps;
    }

    public function getStep(string $step)
    {
        return $this->steps[$step] ?? null;
    }
}
