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
    $fullnameAsText = str_replace(" ", "_", (string) $fullname);
    $filename = $contact === false ? "CONTACT_NOT_FOUND_${fullnameAsText}" : sha1($contact->guid());
    $ext = ".pdf";
    return "${filename}${ext}";
}
