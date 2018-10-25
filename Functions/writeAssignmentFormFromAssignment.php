<?php

namespace TalkSlipSender\Functions;

use TalkSlipSender\AssignmentFormWriterInterface;

function writeAssignmentFormFromAssignment(
    AssignmentFormWriterInterface $Writer,
    array $assignment
) {
    $Writer->create($assignment);
}
