<?php

namespace StudentAssignmentScheduler\Functions\Encryption;

function masterKey(string $path_to_master_key): string
{
    return \base64_decode(
        \file_get_contents(
            $path_to_master_key
        )
    );
}
