<?php

namespace StudentAssignmentScheduler\Functions\InputValidation;

use StudentAssignmentScheduler\Classes\{
    Fullname,
    ListOfContacts
};

function fullnameIsValid(Fullname $fullname, ListOfContacts $ListOfContacts): bool
{
    return $ListOfContacts->contains($fullname);
}
