<?php

namespace TalkSlipSender\Functions\CLI;

function readyForSchedulePrompt(string $month): string
{
    return prompt("Are you ready for to make the schedule for ${month}");
}
