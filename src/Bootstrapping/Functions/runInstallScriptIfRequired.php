<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

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
