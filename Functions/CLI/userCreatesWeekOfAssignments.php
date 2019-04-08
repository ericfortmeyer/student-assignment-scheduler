<?php

namespace StudentAssignmentScheduler\Functions\CLI;

use function StudentAssignmentScheduler\Functions\shouldMakeAssignment;

use StudentAssignmentScheduler\Classes\{
    Fullname,
    ListOfContacts
};

/**
 * Creates data representing a week of assignments
 */
/**
 * @suppress PhanTypeInvalidRightOperand
 * @suppress PhanTypeInvalidUnaryOperandNumeric
 */
function userCreatesWeekOfAssignments(
    array $schedule_for_week,
    string $assignment_date,
    string $year,
    ListOfContacts $ListOfContacts
): array {
    echo blue("Schedule for ${assignment_date}\r\n");
    
    // use the union operator (+) instead of array_merge in order to preserve numeric keys
    return
        ["year" => $year] +
            + [createBibleReading($assignment_date, $ListOfContacts)]
            + array_map(
                function (string $assignment) use ($assignment_date, $ListOfContacts) {
                    echo heading($assignment);
                    return createAssignment(
                        $ListOfContacts,
                        $assignment_date,
                        $assignment,
                        retryUntilFullnameIsValid(
                            new Fullname(
                                readline("Enter student's name: ")
                            ),
                            $ListOfContacts
                        ),
                        userAssignsAssistant($assignment, $ListOfContacts)
                    );
                },
                array_filter(
                    $schedule_for_week,
                    function (string $data, string $key) {
                        return $key !== "date" && shouldMakeAssignment($data);
                    },
                    ARRAY_FILTER_USE_BOTH
                )
            );
}
