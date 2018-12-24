<?php

namespace StudentAssignmentScheduler\Functions;

function monthNumeric(string $month): string
{
    return monthObj($month)->format("m");
}
