<?php

namespace StudentAssignmentScheduler\Functions\CLI;

function setupScheduleRecipients(string $schedule_recipients_config_file)
{
    $add_schedule_recipients_prompt = prompt("Who would you like to recieve the full schedule for each month?.  Are you ready to set that up?");

    $should_add_contacts = readline($add_schedule_recipients_prompt);

    yes($should_add_contacts)
        && setupContacts($schedule_recipients_config_file);
    
    no($should_add_contacts)
        && red("Ok. You can set it up later.")
        && generateContactsFile([], $schedule_recipients_config_file);
}
