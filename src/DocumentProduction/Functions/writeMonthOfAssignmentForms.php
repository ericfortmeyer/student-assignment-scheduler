<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\DocumentProduction\Functions;

use StudentAssignmentScheduler\DocumentProduction\AssignmentFormWriterInterface;
use StudentAssignmentScheduler\ListOfContacts;

function writeMonthOfAssignmentForms(
    AssignmentFormWriterInterface $AssignmentFormWriter,
    ListOfContacts $ListOfContacts,
    array $array_of_month_of_assignments
): void {
    
    array_map(
        function (array $week_of_assignments) use ($AssignmentFormWriter, $ListOfContacts) {
            writeAssignmentFormsFromArrayOfAssignments(
                $AssignmentFormWriter,
                $ListOfContacts,
                $week_of_assignments
            );
        },
        $array_of_month_of_assignments
    );
}
