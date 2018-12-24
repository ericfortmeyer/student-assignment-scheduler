<?php

namespace StudentAssignmentScheduler\Functions\CLI;

function notYesOrNo(string $reply): bool
{
    return !yes($reply) && !no($reply);
}
