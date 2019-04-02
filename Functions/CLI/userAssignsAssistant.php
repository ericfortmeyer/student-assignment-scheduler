<?php

namespace StudentAssignmentScheduler\Functions\CLI;

use StudentAssignmentScheduler\Classes\Fullname;

function userAssignsAssistant(string $assignment) {
    return $assignment !== "Talk" && $assignment !== "Bible Reading"
        ? retryUntilFullnameIsValid(new Fullname(readline("Enter assistant's name: ")))
        : "";
};
