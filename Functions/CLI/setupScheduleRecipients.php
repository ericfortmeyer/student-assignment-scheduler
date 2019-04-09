<?php

namespace StudentAssignmentScheduler\Functions\CLI;

use function StudentAssignmentScheduler\Functions\generateContactsFile;
use function StudentAssignmentScheduler\Functions\promptsForScheduleRecipients;

function setupScheduleRecipients(string $schedule_recipients_config_file)
{
    print purple("Who would you like to recieve the full schedule for each month?") . PHP_EOL . PHP_EOL;

    $add_schedule_recipients_prompt = prompt("Are you ready to set that up");

    $should_add_contacts = readline($add_schedule_recipients_prompt);

    yes($should_add_contacts)
        && addContacts($schedule_recipients_config_file, promptsForScheduleRecipients());
    
    no($should_add_contacts)
        && red("Ok. You can set it up later.")
        && generateContactsFile([], $schedule_recipients_config_file);
    
    print PHP_EOL;
}
