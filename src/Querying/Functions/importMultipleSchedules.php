<?php

namespace StudentAssignmentScheduler\Querying\Functions;

use StudentAssignmentScheduler\{
    MonthOfAssignments,
    Destination
};
use \Ds\Vector;
use function StudentAssignmentScheduler\Utils\Functions\{
    filenamesInDirectory,
    buildPath
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
    return "Nothing was scheduled.  Bye";
}
