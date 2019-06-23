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

use \Ds\Vector;

function loadConfigurationFiles(Vector $config_filenames): Vector
{
    return $config_filenames->map(
        function (string $filename): array {
            return require $filename;
        }
    );
}
