<?php

namespace StudentAssignmentScheduler\Functions\CLI;

use function StudentAssignmentScheduler\Functions\shouldMakeAssignment;

use StudentAssignmentScheduler\Classes\Fullname;

/**
 * Creates data representing a week of assignments
 */
function userCreatesWeekOfAssignments(
    array $schedule_for_week,
    string $assignment_date,
    string $year
): array {
    echo blue("Schedule for ${assignment_date}\r\n");
    
    $userAssignsAssistant = function (string $assignment) {
        return $assignment !== "Talk"
            ? retryUntilFullnameIsValid(new Fullname(readline("Enter assistant's name: ")))
            : "";
    };

    return array_merge(
        ["year" => $year],
        // use the union operator (+) instead of array_merge in order to preserve numeric keys
        [createBibleReading($assignment_date)] +
        array_map(
            function (string $assignment) use ($assignment_date, $userAssignsAssistant) {
                echo heading($assignment);
                return createAssignment(
                    $assignment_date,
                    $assignment,
                    retryUntilFullnameIsValid(
                        new Fullname(
                            readline("Enter student's name: ")
                        )
                    ),
                    $userAssignsAssistant($assignment)
                );
            },
            array_filter(
                $schedule_for_week,
                function (string $data, string $key) {
                    return $key !== "date" && shouldMakeAssignment($data);
                },
                ARRAY_FILTER_USE_BOTH
            )
        )
    );
}