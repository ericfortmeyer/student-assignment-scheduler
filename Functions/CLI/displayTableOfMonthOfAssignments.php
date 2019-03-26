<?php

namespace StudentAssignmentScheduler\Functions\CLI;

use function StudentAssignmentScheduler\Functions\monthOfAssignments;

function displayTableOfMonthOfAssignments(
    string $month,
    string $path_to_assignments_files
): bool {

    $partial = monthOfAssignments($month);
    $array_of_month_of_assignments = $partial($path_to_assignments_files);

    // remove unwanted keys and modify titles that need fixing
    $fixMonthOfAssignments = function (array $week): array {
        $removeIfMatchesKeyYear = function ($key, $value) {
            return $key !== "year";
        };
        $fixAssignmentData = function (int $key, array $assignment) {
            $removeCounselPoint = function (string $key, string $value) {
                return $key !== "counsel_point";
            };
            $fixBibleReadingTitle = function (string $key, string $value) {
                return $value === "bible_reading"
                    ? "Bible Reading"
                    : $value;
            };

            return (new \Ds\Map($assignment))
                ->filter($removeCounselPoint)
                ->map($fixBibleReadingTitle)
                ->toArray();
        };

        return (new \Ds\Map($week))
            ->filter($removeIfMatchesKeyYear)
            ->map($fixAssignmentData)
            ->toArray();
    };

    $displayTableOfData = __NAMESPACE__ . "\\displayTableOfData";

    $didItDisplay = function (?bool $carry, bool $result): bool {
        return $carry || $result;
    };

    $VectorOfAssignments = new \Ds\Vector($array_of_month_of_assignments);
    $VectorOfAssignments->apply($fixMonthOfAssignments);


    return $VectorOfAssignments->map($displayTableOfData)->reduce($didItDisplay);
}
