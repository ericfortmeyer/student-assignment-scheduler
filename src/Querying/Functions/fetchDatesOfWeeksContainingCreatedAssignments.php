<?php

namespace StudentAssignmentScheduler\Querying\Functions;

use StudentAssignmentScheduler\Month;
use StudentAssignmentScheduler\DayOfMonth;
use StudentAssignmentScheduler\Year;
use StudentAssignmentScheduler\Date;
use function StudentAssignmentScheduler\Utils\Functions\buildPath;

use \Ds\Vector;

/**
 * Returns a vector of date strings representing
 * all weeks containing assignments that have
 * already been created by the user.
 *
 * @param Month $month Month the assignments are in
 * @param Year $year Year the assignments are in
 * @return Vector<string>
 */
function fetchDatesOfWeeksContainingCreatedAssignments(Month $month, Year $year): Vector
{
    $path_config = require buildPath(
        dirname(dirname(dirname(__DIR__))),
        "config",
        "path_config.php"
    );
    $path_to_assignments = buildPath(
        $path_config["path_to_assignments"],
        (string) $year
    );
    $dateStringFromFilename = function (string $filename): string {
        $extractDateCharsFromFilename = function (string $filename): array {
            return str_split(explode("_", basename($filename, ".json"))[1], 2);
        };
        [$month_numeric, $day_of_month] = $extractDateCharsFromFilename($filename);
        $month = new Month($month_numeric);
        $dayOfMonth = new DayOfMonth($month, $day_of_month);
        $year = new Year(2019);
        return (string) new Date($month, $dayOfMonth, $year);
    };
    
    return (new Vector(filenamesByMonth($month->asText(), $path_to_assignments)))
        ->map($dateStringFromFilename);
}
