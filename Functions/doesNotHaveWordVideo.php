<?php

namespace StudentAssignmentScheduler\Functions;

function doesNotHaveWordVideo(string $data): bool
{
    return !preg_match("/\bVideo\b/i", $data);
}
