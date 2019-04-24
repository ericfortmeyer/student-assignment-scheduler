<?php

namespace StudentAssignmentScheduler\Functions;

use StudentAssignmentScheduler\Utils\AssignmentFormWriterInterface;

use StudentAssignmentScheduler\Classes\{
    ListOfContacts,
    Fullname
};

use function StudentAssignmentScheduler\Functions\Filenaming\assignmentFormFilename;

use \Ds\Map;


function writeAssignmentFormsFromArrayOfAssignments(
    AssignmentFormWriterInterface $Writer,
    ListOfContacts $ListOfContacts,
    array $assignments
) {
    $filter_year_key = function ($key, $value) {
        return $key !== "year";
    };

    $write_assignments = function (string $assignment_number, array $assignment) use ($Writer, $ListOfContacts) {
        $filename_of_assignment = assignmentFormFilename(
            new Fullname($assignment["name"]),
            $ListOfContacts
        );


        writeAssignmentFormFromAssignment($Writer, $assignment_number, $assignment, $filename_of_assignment);
    };

    (new Map($assignments))
        ->filter($filter_year_key)
        ->map($write_assignments);
}
