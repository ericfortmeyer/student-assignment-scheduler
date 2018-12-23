<?php

namespace TalkSlipSender\Functions;

/**
 * Convert the data into a regular PHP array.
 *
 * Remove any metadata in the Json resulting in
 * an array containing only the information
 * representing each week of the schedule.
 */
function importSchedule(string $path_to_schedules): array
{
    return weeksFrom(importJson($path_to_schedules));
}
