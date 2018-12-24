<?php

namespace StudentAssignmentScheduler\Functions\CLI;

function snakeCaseToUCWords(string $assignment): string
{
    return ucwords(str_replace("_", " ", $assignment));
}
