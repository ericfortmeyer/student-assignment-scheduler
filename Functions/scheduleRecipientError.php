<?php

namespace StudentAssignmentScheduler\Functions;

function scheduleRecipientError(string $schedule_recipients_config_file)
{
    return "Setup incomplete. "
        . PHP_EOL
        . "Who would you like to receive the full schedule each month?"
        . PHP_EOL
        . "You can add their name and email in $schedule_recipients_config_file" . PHP_EOL;
}
