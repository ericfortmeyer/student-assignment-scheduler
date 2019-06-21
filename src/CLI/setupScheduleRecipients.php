<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\CLI;

use function StudentAssignmentScheduler\Encryption\Functions\box;

function setupScheduleRecipients(string $schedule_recipients_config_file, string $key)
{
    print purple("Who would you like to recieve the full schedule for each month?") . PHP_EOL . PHP_EOL;

    $add_schedule_recipients_prompt = prompt("Are you ready to set that up");

    $should_add_contacts = readline($add_schedule_recipients_prompt);

    yes($should_add_contacts)
        && addContacts($schedule_recipients_config_file, $key, promptsForScheduleRecipients());
    
    no($should_add_contacts)
        && red("Ok. You can set it up later.")
        && box(
            [],
            $schedule_recipients_config_file,
            $key
        );
    
    print PHP_EOL;

    return true;
}
