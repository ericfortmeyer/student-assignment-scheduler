<?php

namespace StudentAssignmentScheduler\CLI;

function readyForSchedulePrompt(string $month): string
{
    return prompt("Are you ready to make the schedule for ${month}");
}
