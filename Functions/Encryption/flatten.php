<?php

namespace StudentAssignmentScheduler\Functions\Encryption;

function flatten($thing): string
{
    return \base64_encode(
        serialize($thing)
    );
}
