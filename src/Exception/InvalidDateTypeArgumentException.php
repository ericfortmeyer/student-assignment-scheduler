<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Exception;

final class InvalidDateTypeArgumentException extends \InvalidArgumentException
{
    public function __construct(string $argument, string $class, string $error_message_example)
    {
        $this->message = "It looks like ${argument} is not a valid ${class}."
            . PHP_EOL . "Valid formats are ${error_message_example}.";
    }
}
