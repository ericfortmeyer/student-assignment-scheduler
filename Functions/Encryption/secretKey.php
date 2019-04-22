<?php

namespace StudentAssignmentScheduler\Functions\Encryption;

function secretKey(
    string $path_to_stack_of_keys,
    string $master_key,
    string $associated_data = "studentassignmentscheduler"
): string {
    return unbox($path_to_stack_of_keys, $master_key)->peek();
}