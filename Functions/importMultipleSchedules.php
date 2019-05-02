<?php

namespace StudentAssignmentScheduler\Functions;

use function StudentAssignmentScheduler\Functions\CLI\white;

use \Ds\Vector;

use StudentAssignmentScheduler\Classes\{
    MonthOfAssignments,
    Destination
};

/**
 * @param Destination $path_to_json_schedules
 * @return Vector Available schedules
 */
function importMultipleSchedules(Destination $path_to_json_schedules): Vector
{
    return (new Vector(
        filenamesInDirectory(
            $path_to_json_schedules,
            messageIfEmpty(),
            true
        )
    ))->map(function (string $basename) use ($path_to_json_schedules): string {
        return buildPath($path_to_json_schedules, $basename);
    })->map(function (string $absolute_path_to_file): MonthOfAssignments {
        return new MonthOfAssignments(
            importJson($absolute_path_to_file)
        );
    });
}

function messageIfEmpty(): string
{
    return white("Nothing was scheduled.  Bye" . PHP_EOL . PHP_EOL);
}
