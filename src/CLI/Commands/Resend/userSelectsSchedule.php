<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\CLI\Commands\Resend;

use function StudentAssignmentScheduler\Utils\Functions\{
    filenamesInDirectory,
    getConfig
};
use function StudentAssignmentScheduler\CLI\displayList;
use \Ds\Vector;

function userSelectsSchedule(): string
{
    $path_to_schedules = getConfig()["schedules_destination"];
    $schedule_filenames = new Vector(filenamesInDirectory($path_to_schedules));
    
    displayList(
        $schedule_filenames->map(
            function (string $schedule_filename): string {
                return basename($schedule_filename, ".pdf");
            }
        )
    );
    $index = readline(
        "Select the month of the schedule you want to send by typing the number to the left of it: "
    );
    return $schedule_filenames->get($index);
}