<?php

namespace StudentAssignmentScheduler\Functions;

use \Ds\Vector;
use \Closure;

/**
 * Use to convert json assignments into an array of data.
 *
 * @param string $month Use to select which files to import.
 * @param string $path_to_json_assignments
 * @param ?Closure $importFunc Use for testing or special cases.
 *
 * @return array The data derived from the json files.
 */
function importAssignments(string $month, string $path_to_json_assignments, ?Closure $importFunc = null): array
{
    $partialFunc = $importFunc ?? function (string $path_to_json_assignments): \Closure {
        return function (string $json_file) use ($path_to_json_assignments): array {
            return importJson("${path_to_json_assignments}/${json_file}");
        };
    };

    $importJson = $partialFunc($path_to_json_assignments);

    $filenames = shiftFinalWeekInFollowingMonth(
        filenamesByMonth($month, $path_to_json_assignments)
    );

    return (new Vector($filenames))->map($importJson)->toArray();
}
