<?php

namespace StudentAssignmentScheduler\FileNaming\Functions;

use StudentAssignmentScheduler\{
    Fullname,
    ListOfContacts
};

function assignmentFormFilename(Fullname $fullname, ListOfContacts $ListOfContacts): string
{
    $doIfContactNotFound = function (): bool {
        return false;
    };
    $contact = $ListOfContacts->findByFullname($fullname)->getOrElse($doIfContactNotFound);
    $filename = $contact === false ? "CONTACT_NOT_FOUND_${fullname}" : sha1($contact->guid());
    $ext = ".pdf";
    return "${filename}${ext}";
}
