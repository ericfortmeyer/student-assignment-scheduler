<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */
 declare(strict_types=1);

namespace StudentAssignmentScheduler\Querying\Functions;

use StudentAssignmentScheduler\ListOfScheduleRecipients;
use function StudentAssignmentScheduler\Encryption\Functions\{
    masterKey,
    secretKey,
    unbox
};

function getScheduleRecipients(
    string $path_to_contacts,
    string $path_to_master_key,
    string $path_to_stack_of_keys
): ListOfScheduleRecipients {
    $master_key = masterKey($path_to_master_key);
    $secret_Key = secretKey($path_to_stack_of_keys, $master_key);

    $decrypted = unbox($path_to_contacts, $secret_Key);
    return is_array($decrypted)
        ? new ListOfScheduleRecipients($decrypted)
        : $decrypted;
}
