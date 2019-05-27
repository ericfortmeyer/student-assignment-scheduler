<?php

namespace StudentAssignmentScheduler\FileNaming\Functions;

use StudentAssignmentScheduler\{
    Fullname,
    ListOfContacts
};

function assignmentFormFilename(Fullname $fullname, ListOfContacts $ListOfContacts): string
{
    $ext = ".pdf";
    return "{$ListOfContacts->findByFullname($fullname)->guid()}${ext}";
}
