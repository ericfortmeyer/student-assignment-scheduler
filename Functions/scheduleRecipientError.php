<?php

namespace TalkSlipSender\Functions;

function scheduleRecipientError(string $schedule_recipients_config_file)
{
    return "Setup incomplete. "
        . PHP_EOL
        . "Who would you like to receive the full schedule each month?"
        . PHP_EOL
        . "You can set it up in $schedule_recipients_config_file" . PHP_EOL;
}
