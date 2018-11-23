<?php

namespace TalkSlipSender\Functions;

use TalkSlipSender\Utils\ScheduleWriter;

/**
 * Create the schedule for the month
 *
 * Uses the json schedule and the json assignment files
 * to generate a pdf schedule for the month
 *
 * @param ScheduleWriter $ScheduleWriter
 * @param string $path_to_json_assignments_files
 * @param string $path_to_json_schedules
 * @param string $month
 * @return string What was the filename of the schedule created?
 */
function writeSchedule(
    ScheduleWriter $ScheduleWriter,
    string $path_to_json_assignments_files,
    string $path_to_json_schedules,
    string $month
): string {


    return $ScheduleWriter->create(
        $path_to_json_assignments_files,
        weeksFrom(importJson("${path_to_json_schedules}/${month}.json")),
        $month
    );
}
