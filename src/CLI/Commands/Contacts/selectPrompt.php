<?php

namespace StudentAssignmentScheduler\CLI\Commands\Contacts;

function selectPrompt(string $action): string
{
    return "Select the contact you want to ${action} by typing the number to the left of it: ";
}
