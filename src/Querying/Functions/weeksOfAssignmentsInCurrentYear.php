<?php

namespace StudentAssignmentScheduler\Querying\Functions;

use function StudentAssignmentScheduler\Utils\Functions\filenamesInDirectory;
use function StudentAssignmentScheduler\Utils\Functions\buildPath;
use \Ds\Map;
use \Ds\Vector;

function weeksOfAssignmentsInCurrentYear(): Map
{
    $path_config = require __DIR__ . "/../../../config/path_config.php";
    $path_to_assignments_in_current_year = buildPath($path_config["path_to_assignments"], date_create()->format("Y"));
    $appendDirectoryToFilename = function ($key, string $filename) use ($path_to_assignments_in_current_year): string {
        return buildPath($path_to_assignments_in_current_year, $filename);
    };
    $importWeeksOfAssignments = function ($key, string $fullpath): array {
        return weeksFrom(importJson($fullpath));
    };
    $justIndividualAssignments = function (
        Map $IndividualAssignments,
        int $weekIndex,
        array $weekOfAssignments
    ): Map {
        $addAssignment = function (
            int $assignment_number,
            array $assignment
        ) use (
            $weekIndex,
            $IndividualAssignments
): void {
            $key = [$weekIndex, $assignment_number];
            $IndividualAssignments->put($key, $assignment);
        };
        array_map(
            $addAssignment,
            array_keys($weekOfAssignments),
            $weekOfAssignments
        );
        return $IndividualAssignments;
    };
    $filenames = (new Vector(filenamesInDirectory($path_to_assignments_in_current_year)))
        ->filter(__NAMESPACE__ . "\\removeAssignmentCopies");

    return (new Map($filenames))->map($appendDirectoryToFilename)
        ->map($importWeeksOfAssignments)
        ->reduce($justIndividualAssignments, new Map());
}
