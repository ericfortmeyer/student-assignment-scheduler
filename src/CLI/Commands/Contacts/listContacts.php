<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\CLI\Commands\Contacts;

use StudentAssignmentScheduler\{
    ListOfContacts,
    Contact
};

use function StudentAssignmentScheduler\CLI\displayList;

function listContacts(ListOfContacts $contacts)
{
    $toString = function (Contact $contact): string {
        return (string) $contact;
    };
    
    displayList($contacts->map($toString)->toArray());
}
