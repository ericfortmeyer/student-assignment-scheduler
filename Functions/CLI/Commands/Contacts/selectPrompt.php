<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\Contacts;

function selectPrompt(string $action): string
{
    return "Select the contact you want to ${action} by typing the number on the left of it: ";
}
