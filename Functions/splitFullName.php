<?php

namespace StudentAssignmentScheduler\Functions;

function splitFullName(string $fullname): array
{
    return explode(" ", $fullname);
}
