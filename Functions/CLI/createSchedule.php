<?php

namespace StudentAssignmentScheduler\Functions\CLI;

use function StudentAssignmentScheduler\Functions\shouldMakeAssignment;

function createSchedule(array $schedule_for_week, string $month)
{
    $date = "${month} {$schedule_for_week["date"]}";
    echo blue("Schedule for ${date}\r\n");
    // use the union operator (+) instead of array_merge in order to preserve numeric keys
    $test = [createBibleReading($date)] +
        array_map(
            function (string $assignment) use ($date) {
                echo heading($assignment);
                return createAssignment(
                    $date,
                    $assignment,
                    readline("Enter student's name: "),
                    $assignment !== "Talk" ? readline("Enter assistant's name: ") : ""
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
