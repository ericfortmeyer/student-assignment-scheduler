<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\Amend;

function promptUserForMonth(): string
{
    return readline("What is the month of the schedule you would like to change? ");
}
