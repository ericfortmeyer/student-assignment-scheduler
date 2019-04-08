<?php

namespace StudentAssignmentScheduler\Functions\CLI\Commands\Contacts;

use \Ds\Set;

function listContacts(Set $contacts)
{
    print_r($contacts->toArray());
}
