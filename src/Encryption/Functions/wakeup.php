<?php
/**
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Encryption\Functions;

/**
 * Unserialize a base64 decoded string.
 *
 * @param string $flattened Base64 encoded serialized value
 * @return mixed
 */
function wakeup(string $flattened)
{
    return unserialize(
        base64_decode($flattened)
    );
}
