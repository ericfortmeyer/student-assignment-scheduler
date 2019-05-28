<?php

namespace StudentAssignmentScheduler\Encryption\Functions;

function box(
    $sensitive_data,
    string $path_to_sensitive_data,
    string $key,
    string $associated_data = "studentassignmentscheduler"
): void {
    \file_put_contents(
        $path_to_sensitive_data,
        \base64_encode(
            encrypt(
                flatten($sensitive_data),
                $key,
                $associated_data
            )
        ),
        LOCK_EX
    );
}