<?php

namespace TalkSlipSender\Functions;

use TalkSlipSender\Utils\AssignmentFormWriterInterface;

function writeAssignmentFormsFromArrayOfAssignments(
    AssignmentFormWriterInterface $Writer,
    array $assignments
) {
    array_map(
        function ($assignment) use ($Writer) {
            writeAssignmentFormFromAssignment($Writer, $assignment);
        },
        array_filter(
            $assignments,
            function ($key) {
                return $key !== "year";
            },
            ARRAY_FILTER_USE_KEY
        )
    );
}
