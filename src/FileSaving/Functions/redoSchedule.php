<?php

namespace StudentAssignmentScheduler\FileSaving\Functions;

use StudentAssignmentScheduler\{
    FileSaving\ScheduleWriterInterface,
    Month
};

use function StudentAssignmentScheduler\Bootstrapping\Functions\buildPath;
use function StudentAssignmentScheduler\Querying\Functions\importAssignments;
use function StudentAssignmentScheduler\Utils\Functions\removeYearKey;

function redoSchedule(
    ScheduleWriterInterface $ScheduleWriter,
    Month $Month,
    array $schedule_for_month,
    string $path_to_schedules,
    string $path_to_json_assignments
): string {
    
    $newAssignments =  removeYearKey(
        importAssignments($Month->asText(), $path_to_json_assignments)
    );

    $schedule_filename = buildPath(
        $path_to_schedules,
        $Month->asText() . ".pdf"
    );

    // remove original schedule
    file_exists($schedule_filename) && unlink($schedule_filename);

    // create new schedule
    return $ScheduleWriter->create(
        $newAssignments,
        $schedule_for_month,
        $Month->asText()
    );
}
