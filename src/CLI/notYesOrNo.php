<?php

namespace StudentAssignmentScheduler\CLI;

function notYesOrNo(string $reply): bool
{
    return !yes($reply) && !no($reply);
}
