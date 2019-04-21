<?php

namespace StudentAssignmentScheduler\Functions\CLI;

use function StudentAssignmentScheduler\Functions\shouldMakeAssignment;

use StudentAssignmentScheduler\Classes\{
    Fullname,
    ListOfContacts,
    WeekOfAssignments,
    Assignment
};

/**
 * Creates data representing a week of assignments
 */
/**
 * @suppress PhanTypeInvalidRightOperand
 * @suppress PhanTypeInvalidUnaryOperandNumeric
 */
function userCreatesWeekOfAssignments(
    WeekOfAssignments $schedule_for_week,
    string $assignment_date,
    string $year,
    ListOfContacts $ListOfContacts
): array {
    echo blue("Schedule for ${assignment_date}\r\n");

    $userCreatesAssignments = function (string $key, Assignment $assignment) use ($assignment_date, $ListOfContacts) {
        $assignment_name = (string) $assignment;
        echo heading($assignment_name);
        return createAssignment(
            $ListOfContacts,
            $assignment_date,
            $assignment_name,
            retryUntilFullnameIsValid(
                new Fullname(
                    readline("Enter student's name: ")
                ),
                $ListOfContacts
            ),
            userAssignsAssistant($assignment_name, $ListOfContacts)
        );
    };

    $onlyAssignmentsThatShouldBeScheduled = function (string $key, Assignment $assignment) {
        return shouldMakeAssignment((string) $assignment);
    };

    // use the union operator (+) instead of array_merge in order to preserve numeric keys
    return ["year" => $year]
            + [createBibleReading($assignment_date, $ListOfContacts)]
            + $schedule_for_week->assignments()
                ->filter($onlyAssignmentsThatShouldBeScheduled)
                ->map($userCreatesAssignments)
                ->toArray();
}
