<?php

namespace StudentAssignmentScheduler\Functions\Encryption;

function wakeup(string $flattened)
{
    return unserialize(
        base64_decode($flattened)
    );
}
