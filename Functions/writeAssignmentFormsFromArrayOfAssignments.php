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

    $write_assignments = function (array $assignment) use ($Writer) {
        writeAssignmentFormFromAssignment($Writer, $assignment);
    };

    (new Vector(
        (new Map($assignments))->filter($filter_year_key)
    ))->map($write_assignments);
}
