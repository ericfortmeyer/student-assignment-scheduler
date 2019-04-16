<?php

namespace StudentAssignmentScheduler\Functions;

use StudentAssignmentScheduler\{
    Classes\Month,
    Classes\DayOfMonth,
    Classes\Destination,
    Rules\Context,
    Rules\JsonAssignmentFilenamePolicy
};

use \DateTimeImmutable;

function copyAndSwapJsonAssignment(
    array $original_assignment,
    array $new_assignment,
    array $week_of_assignments,
    array $schedule_for_month,
    Month $Month,
    DayOfMonth $DayOfMonth,
    Destination $path_to_json_assignments,
    DateTimeImmutable $date_time,
    bool $test_mode = false,
    ?string $test_registry = null
): void {

    defined(__NAMESPACE__ . "\\ORIGINAL_FILENAME") || define(
        __NAMESPACE__ . "\\ORIGINAL_FILENAME",
        // filename of original
        (function (
            array $schedule_for_month,
            Destination $path_to_json_assignments,
            Month $Month,
            DayOfMonth $DayOfMonth
        ): string {


            $schedule_for_month[JsonAssignmentFilenamePolicy::MONTH] = $Month->asText();

            return Filenaming\jsonAssignmentFilename(
                $path_to_json_assignments,
                $Month,
                $DayOfMonth,
                new JsonAssignmentFilenamePolicy(
                    new Context(
                        [
                            JsonAssignmentFilenamePolicy::SCHEDULE_FOR_MONTH => $schedule_for_month,
                            JsonAssignmentFilenamePolicy::DAY_OF_MONTH => $DayOfMonth,
                            JsonAssignmentFilenamePolicy::MONTH => $Month
                        ]
                    )
                )
            );
        })(
            $schedule_for_month,
            $path_to_json_assignments,
            $Month,
            $DayOfMonth
        )
    );

    save(
        $week_of_assignments,
        Filenaming\jsonAssignmentCopyFilename(
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
        array_replace($week_of_assignments, $new_assignment),
        $week_of_assignments,
        ORIGINAL_FILENAME,
        $test_mode,
        $test_registry
    );
}
