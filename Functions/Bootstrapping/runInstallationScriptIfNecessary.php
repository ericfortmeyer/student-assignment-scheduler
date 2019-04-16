<?php

namespace StudentAssignmentScheduler\Functions\Bootstrapping;

function runInstallationScriptIfNecessary(string $path_to_vendor_folder): void
{
    file_exists($path_to_vendor_folder)
        || system("sh bin/install.sh");
}
