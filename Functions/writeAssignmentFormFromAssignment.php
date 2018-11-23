<?php

namespace TalkSlipSender\Functions;

use TalkSlipSender\Utils\AssignmentFormWriterInterface;

function writeAssignmentFormFromAssignment(
    AssignmentFormWriterInterface $Writer,
    array $assignment
) {
    $Writer->create($assignment);
}
