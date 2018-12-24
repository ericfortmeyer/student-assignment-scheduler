<?php

namespace StudentAssignmentScheduler\Functions;

function contactSetupError(string $contacts_file)
{
    return "Contacts haven't been set up yet. Set them up in $contacts_file\r\n";
}
