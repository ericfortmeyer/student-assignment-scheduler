<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Querying\Functions;

/**
 * Convert the data into a regular PHP array.
 *
 * Remove any metadata in the Json resulting in
 * an array containing only the information
 * representing each week of the schedule.
 */
function importSchedule(string $filename, string $path_to_schedules): array
{
    return weeksFrom(importJson("${path_to_schedules}/${filename}"));
}
