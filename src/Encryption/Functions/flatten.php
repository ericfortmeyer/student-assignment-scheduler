<?php

namespace StudentAssignmentScheduler\Encryption\Functions;

function flatten($thing): string
{
    return \base64_encode(
        serialize($thing)
    );
}