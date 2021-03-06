<?php

namespace StudentAssignmentScheduler\Exception;

final class InvalidWeekOfAssignmentsArgumentException extends \InvalidArgumentException
{
    public function __construct(string $argument_type, string $value)
    {
        $this->message = "It looks like the ${argument_type} with value: ${value} "
            . "is invalid." . PHP_EOL;
    }
}
