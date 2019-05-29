<?php

namespace StudentAssignmentScheduler\FileNaming\Functions;

use StudentAssignmentScheduler\{
    Fullname,
    ListOfContacts
};

function assignmentFormFilename(Fullname $fullname, ListOfContacts $ListOfContacts): string
{
    $contact = $ListOfContacts->findByFullname($fullname);
    $filename = sha1($contact->guid());
    $ext = ".pdf";
    return "${filename}${ext}";
}
