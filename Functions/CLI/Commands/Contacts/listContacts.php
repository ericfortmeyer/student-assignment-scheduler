<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\Contacts;

use StudentAssignmentScheduler\Classes\ListOfContacts;

function listContacts(ListOfContacts $contacts)
{
    print_r($contacts->toArray());
}
