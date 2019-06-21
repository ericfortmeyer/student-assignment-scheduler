<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */
namespace StudentAssignmentScheduler\Encryption\Functions;

/**
 * Key used to decrypt the secret key.
 *
 * @param string $path_to_master_key
 * @return string
 */
function masterKey(string $path_to_master_key): string
{
    return \base64_decode(
        \file_get_contents(
            $path_to_master_key
        )
    );
}
