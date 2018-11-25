<?php

namespace TalkSlipSender\Functions;

use TalkSlipSender\Utils\AssignmentFormWriterInterface;
use \Ds\Map;

function writeAssignmentFormsFromArrayOfAssignments(
    AssignmentFormWriterInterface $Writer,
    array $assignments
) {
    (new Map($assignments))->filter(function ($key) {
        return $key !== "year";
    })->map(function ($assignment) use ($Writer) {
        writeAssignmentFormFromAssignment($Writer, $assignment);
    });
}
