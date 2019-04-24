<?php

namespace StudentAssignmentScheduler\Functions\Filenaming;

use StudentAssignmentScheduler\Classes\{
    Fullname,
    ListOfContacts
};

function assignmentFormFilename(Fullname $fullname, ListOfContacts $ListOfContacts): string
{
    $ext = ".pdf";
    return "{$ListOfContacts->findByFullname($fullname)->guid()}${ext}";
}
