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

namespace StudentAssignmentScheduler\Utils\Functions;

/**
 * Use to automatically include functions
 * Recursively includes files in the given
 * This file and system files are exluded
 * @param string $directory
 * @return void
 */
function includeFilesInDirectory(string $directory): void
{
    array_map(
        function (string $filename) use ($directory) {
            is_dir("${directory}/${filename}")
                ? includeFilesInDirectory("${directory}/${filename}")
                : require_once "${directory}/${filename}";
        },
        array_diff(
            scandir($directory),
            [".", "..", ".DS_Store", basename(__FILE__)]
        )
    );
}
