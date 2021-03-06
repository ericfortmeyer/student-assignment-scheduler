<?php

namespace StudentAssignmentScheduler\Bootstrapping\Functions;

function runInstallScriptIfRequired(string $vendor_directory_name, string $installation_script_path): void
{
    $installation_script_arg = buildPath(
        realpath(dirname($vendor_directory_name)),
        basename($vendor_directory_name)
    );

    $installation_script_with_arg = realpath($installation_script_path) . " $installation_script_arg";

    \file_exists($vendor_directory_name)
        || \system("bash $installation_script_with_arg");
}
