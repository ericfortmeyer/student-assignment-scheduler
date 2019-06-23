<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Querying\Functions;

function monthOfAssignments(string $month): \Closure
{
    return function (string $path_to_assignments_files) use ($month): array {
        return array_map(
            function (string $filename) use ($month, $path_to_assignments_files) {
                return importJson("$path_to_assignments_files/$filename");
            },
            filenamesByMonth($month, $path_to_assignments_files)
        );
    };
}
