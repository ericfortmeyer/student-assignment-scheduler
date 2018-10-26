<?php

namespace TalkSlipSender\Functions;

use TalkSlipSender\ScheduleWriter;

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
