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
 * Base64 encode a serialized value.
 *
 * @param mixed $thing
 * @return string Base64 string
 */
function flatten($thing): string
{
    return \base64_encode(
        serialize($thing)
    );
}
