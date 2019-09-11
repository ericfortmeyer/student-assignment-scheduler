<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

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
