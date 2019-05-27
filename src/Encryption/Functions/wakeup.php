<?php

namespace StudentAssignmentScheduler\Encryption\Functions;

function wakeup(string $flattened)
{
    return unserialize(
        base64_decode($flattened)
    );
}
