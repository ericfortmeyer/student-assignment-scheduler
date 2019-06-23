<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */
 declare(strict_types=1);

namespace StudentAssignmentScheduler\Bootstrapping\Functions;

use \Ds\Vector;

function makeRequiredDirectories(array $required_directories)
{
    $RequiredDirectories = new Vector($required_directories);
    
    $make_dir = function (string $dir) {
        file_exists($dir) || mkdir($dir, 0770, true);
    };

    $RequiredDirectories->map($make_dir);
}
