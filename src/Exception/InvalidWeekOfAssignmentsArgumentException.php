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

final class InvalidWeekOfAssignmentsArgumentException extends \InvalidArgumentException
{
    public function __construct(string $argument_type, string $value)
    {
        $this->message = "It looks like the ${argument_type} with value: ${value} "
            . "is invalid." . PHP_EOL;
    }
}
