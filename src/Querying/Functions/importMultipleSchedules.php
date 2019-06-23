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

use StudentAssignmentScheduler\MonthOfAssignments;
use StudentAssignmentScheduler\Destination;
use \Ds\Vector;
use function StudentAssignmentScheduler\Utils\Functions\filenamesInDirectory;
use function StudentAssignmentScheduler\Utils\Functions\buildPath;

/**
 * Import all schedules from a given directory.
 *
 * @param Destination $path_to_json_schedules
 * @return Vector Available schedules
 */
function importMultipleSchedules(Destination $path_to_json_schedules): Vector
{
    return (new Vector(
        filenamesInDirectory(
            (string) $path_to_json_schedules,
            messageIfEmpty(),
            true
        )
    ))->map(function (string $basename) use ($path_to_json_schedules): string {
        return buildPath((string) $path_to_json_schedules, $basename);
    })->map(function (string $absolute_path_to_file): MonthOfAssignments {
        return new MonthOfAssignments(
            importJson($absolute_path_to_file)
        );
    });
}

/**
 * @return string
 */
function messageIfEmpty(): string
{
    return "Nothing was scheduled.  Bye";
}
