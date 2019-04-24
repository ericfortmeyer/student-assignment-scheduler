<?php

namespace StudentAssignmentScheduler\Functions\Encryption;

function unbox(
    string $path_to_sensitive_data,
    string $key,
    string $associated_data = "studentassignmentscheduler"
) {
    return wakeup(
        decrypt(
            \base64_decode(
                \file_get_contents(
                    $path_to_sensitive_data
                )
            ),
            $associated_data,
            $key
        )
    );
}
