<?php

namespace StudentAssignmentScheduler\Functions;

use StudentAssignmentScheduler\Utils\AssignmentFormWriterInterface;
use \Ds\Map;
use \Ds\Vector;

function writeAssignmentFormsFromArrayOfAssignments(
    AssignmentFormWriterInterface $Writer,
    array $assignments
) {
    $filter_year_key = function ($key, $value) {
        return $key !== "year";
    };

    $write_assignments = function (string $assignment_number, array $assignment) use ($Writer) {
        writeAssignmentFormFromAssignment($Writer, $assignment_number, $assignment);
    };

    (new Map($assignments))
        ->filter($filter_year_key)
        ->map($write_assignments);
}
