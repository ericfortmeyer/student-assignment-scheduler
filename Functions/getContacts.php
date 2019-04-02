<?php

namespace StudentAssignmentScheduler\Functions;

function getContacts(): array
{
    return require __DIR__ . "/../config/contacts.php";
}
