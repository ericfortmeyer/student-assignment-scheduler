<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\CLI;

define("UNDERSCORE", "_");
define("DASH", "-");
define("BAR", "|");

function displayTableOfData(array $data): bool
{


    $values = $headers = "";
    $result = false;


    foreach ($data as $key => $value) {
        if (is_array($value)) {
            continue;
        }

        $padded = str_pad($key, strlen($value), " ", STR_PAD_BOTH);
        $headers .= green(BAR) . " ${padded} ";
    }
    $line = $headers ? str_repeat(DASH, (int) round(strlen($headers) * 0.645)) . PHP_EOL : "";
    print green($line);

    print $headers;
    $headers ? print green(BAR . PHP_EOL) : null;

    foreach ($data as $key => $value) {
        if (is_array($value)) {
            $result = displayTableOfData($value);
            continue;
        }
        $val_padded = str_pad($value, strlen($key), " ", STR_PAD_BOTH);
        $values .= green(BAR) . " ${val_padded} ";
    }
    print $values;
    $values ? print green(BAR . PHP_EOL) : null;
    print green(str_repeat(UNDERSCORE, (int) round(strlen($headers) * 0.645))) . PHP_EOL;

    return !empty($data) || $result;
}
