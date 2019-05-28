<?php

namespace StudentAssignmentScheduler\Persistence\Functions;

use StudentAssignmentScheduler\{
    Date,
    MonthOfAssignments,
    WeekOfAssignments,
    Destination,
    Policies\JsonAssignmentFilenamePolicy
};
use \DateTimeImmutable;
use function StudentAssignmentScheduler\FileNaming\Functions\{
    jsonAssignmentFilename,
    jsonAssignmentCopyFilename
};


function copyAndSwapJsonAssignment(
    array $original_assignment,
    array $new_assignment,
    WeekOfAssignments $week_of_assignments,
    MonthOfAssignments $schedule_for_month,
    Date $date,
    Destination $path_to_json_assignments,
    DateTimeImmutable $date_time,
    bool $test_mode = false,
    ?string $test_registry = null
): void {

    defined(__NAMESPACE__ . "\\ORIGINAL_FILENAME") || define(
        __NAMESPACE__ . "\\ORIGINAL_FILENAME",
        // filename of original
        (function (
            MonthOfAssignments $schedule_for_month,
            Destination $path_to_json_assignments,
            Date $date
        ): string {

            return jsonAssignmentFilename(
                $path_to_json_assignments,
                $date,
                new JsonAssignmentFilenamePolicy(
                    $schedule_for_month,
                    $date
                )
            );
        })(
            $schedule_for_month,
            $path_to_json_assignments,
            $date
        )
    );

    $week_of_assignments_as_array = $week_of_assignments->toArrayWithYearKey($date->year());

    save(
        $week_of_assignments_as_array,
        jsonAssignmentCopyFilename(
            $path_to_json_assignments,
            $date_time,
            basename(ORIGINAL_FILENAME)
        ),
        $test_mode,
        $test_registry
    );

    // swap assignment
    (function (
        array $replaced_assignment,
        array $week_of_assignments,
        string $filename,
        bool $test_mode = false,
        ?string $test_registry = null
    ): void {
        unlink($filename);
        save($replaced_assignment, $filename, $test_mode, $test_registry);
    })(
        array_replace($week_of_assignments_as_array, $new_assignment),
        $week_of_assignments_as_array,
        ORIGINAL_FILENAME,
        $test_mode,
        $test_registry
    );
}
